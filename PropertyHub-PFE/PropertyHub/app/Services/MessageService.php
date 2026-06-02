<?php

namespace App\Services;

use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class MessageService
{
    /* -----------------------------------------------------------------
     | Read paths
     | ----------------------------------------------------------------- */

    /**
     * Inbox-style list of most recent messages grouped by conversation partner.
     */
    public function getRecentConversations(int $userId, int $limit = 10): array
    {
        $messages = Message::with('sender', 'receiver')
            ->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $conversations = [];
        $seen = [];

        foreach ($messages as $message) {
            $contactId = $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
            if (!in_array($contactId, $seen, true)) {
                $conversations[] = $message;
                $seen[] = $contactId;
                if (count($conversations) >= $limit) {
                    break;
                }
            }
        }
        return $conversations;
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
