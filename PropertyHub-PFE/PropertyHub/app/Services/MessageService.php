<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Message;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class MessageService
{
    /* -----------------------------------------------------------------
     | Read paths
     | ----------------------------------------------------------------- */

    public function getAllowedContacts(int $userId, string $role): array
    {
        $contacts = collect();
        if ($role === 'admin') {
            $contacts = User::where('role', 'agent')->get();
        } elseif ($role === 'agent') {
            // Agent can message Admin and Buyers who have appointments for their properties
            $adminContacts = User::where('role', 'admin')->get();
            
            $buyerIds = \App\Models\Appointment::whereHas('property', function ($query) use ($userId) {
                $query->where('agent_id', $userId);
            })->pluck('buyer_id')->unique();
            
            $buyerContacts = User::whereIn('id', $buyerIds)->get();
            $contacts = $adminContacts->concat($buyerContacts)->unique('id');
        } elseif ($role === 'buyer') {
            // Buyer can message Agents of properties they made appointments for
            $agentIds = \App\Models\Appointment::where('buyer_id', $userId)
                ->with('property')
                ->get()
                ->pluck('property.agent_id')
                ->unique()
                ->filter(); // remove nulls
                
            $contacts = User::whereIn('id', $agentIds)->get();
        }

        $conversations = [];
        foreach ($contacts as $contact) {
            $latestMessage = Message::where(function($q) use ($userId, $contact) {
                $q->where('sender_id', $userId)->where('receiver_id', $contact->id);
            })->orWhere(function($q) use ($userId, $contact) {
                $q->where('sender_id', $contact->id)->where('receiver_id', $userId);
            })->orderBy('created_at', 'desc')->first();

            $conversations[] = (object) [
                'contact' => $contact,
                'latest_message' => $latestMessage,
                'updated_at' => $latestMessage ? $latestMessage->created_at : $contact->created_at,
            ];
        }

        usort($conversations, function ($a, $b) {
            return $b->updated_at <=> $a->updated_at;
        });

        return $conversations;
    }

    /**
     * Apply role-based filtering to a message query.
     *
     * - admin : only conversations where the other party is an agent
     * - agent : only conversations where the other party is a buyer or admin
     * - buyer : only conversations where the other party is an agent
     */
    private function applyRoleFilter($query, int $userId, string $role)
    {
        if ($role === 'admin') {
            $query->where(function ($q) {
                $q->whereHas('sender', fn($q) => $q->where('role', 'agent'))
                  ->orWhereHas('receiver', fn($q) => $q->where('role', 'agent'));
            });
        } elseif ($role === 'agent') {
            $query->where(function ($q) {
                $q->where(function ($sub) {
                    $sub->whereHas('sender', fn($q) => $q->where('role', 'buyer'))
                        ->orWhereHas('receiver', fn($q) => $q->where('role', 'buyer'));
                });
                $q->orWhere(function ($sub) {
                    $sub->whereHas('sender', fn($q) => $q->where('role', 'admin'))
                        ->orWhereHas('receiver', fn($q) => $q->where('role', 'admin'));
                });
            });
        } elseif ($role === 'buyer') {
            $query->where(function ($q) {
                $q->whereHas('sender', fn($q) => $q->where('role', 'agent'))
                  ->orWhereHas('receiver', fn($q) => $q->where('role', 'agent'));
            });
        }

        return $query;
    }

    /**
     * Check whether the authenticated user is allowed to conversation-partner with $otherUserId.
     */
    public function canConversate(int $authId, string $authRole, int $otherUserId): bool
    {
        $other = User::find($otherUserId);
        if (!$other) {
            return false;
        }

        if ($authRole === 'admin') {
            return $other->role === 'agent';
        }

        if ($authRole === 'buyer') {
            return $other->role === 'agent';
        }

        if ($authRole === 'agent') {
            return in_array($other->role, ['admin', 'buyer'], true);
        }

        return false;
    }

    public function getConversation(int $userId1, int $userId2, int $perPage = 20): LengthAwarePaginator
    {
        return Message::with('sender', 'receiver')
            ->where(function ($q) use ($userId1, $userId2) {
                $q->where('sender_id', $userId1)->where('receiver_id', $userId2);
            })
            ->orWhere(function ($q) use ($userId1, $userId2) {
                $q->where('sender_id', $userId2)->where('receiver_id', $userId1);
            })
            ->orderBy('created_at', 'asc')
            ->paginate($perPage);
    }

    public function getInbox(int $userId, int $perPage = 20): LengthAwarePaginator
    {
        return Message::with('sender', 'receiver')
            ->where('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getSentMessages(int $userId, int $perPage = 20): LengthAwarePaginator
    {
        return Message::with('sender', 'receiver')
            ->where('sender_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getUnreadCount(int $userId): int
    {
        return Message::where('receiver_id', $userId)
            ->whereNull('read_at')
            ->count();
    }

    /* -----------------------------------------------------------------
     | Write paths
     | ----------------------------------------------------------------- */

    public function sendMessage(int $senderId, int $receiverId, string $content): Message
    {
        return DB::transaction(function () use ($senderId, $receiverId, $content) {
            User::findOrFail($senderId);
            User::findOrFail($receiverId);

            if ($senderId === $receiverId) {
                throw new \Exception("Cannot send message to yourself.");
            }

            return Message::create([
                'content'     => trim($content),
                'timestamp'   => Carbon::now(),
                'sender_id'   => $senderId,
                'receiver_id' => $receiverId,
            ]);
        });
    }

    public function markConversationAsRead(int $userId, int $otherUserId): int
    {
        return Message::where('receiver_id', $userId)
            ->where('sender_id', $otherUserId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function deleteMessage(int $messageId, int $userId): void
    {
        DB::transaction(function () use ($messageId, $userId) {
            $message = Message::findOrFail($messageId);
            if ($message->sender_id !== $userId && $message->receiver_id !== $userId) {
                throw new \Exception("Unauthorized action.");
            }
            $message->delete();
        });
    }
}
