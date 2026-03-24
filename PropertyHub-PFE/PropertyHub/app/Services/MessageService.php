<?php

namespace App\Services;

use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class MessageService
{
    /**
     * Send a message between users.
     */
    public function sendMessage(int $senderId, int $receiverId, string $content): Message
    {
        return DB::transaction(function () use ($senderId, $receiverId, $content) {
            User::findOrFail($senderId);
            User::findOrFail($receiverId);

            if ($senderId === $receiverId) {
                throw new \Exception("Cannot send message to yourself.");
            }

            return Message::create([
                'content' => trim($content),
                'timestamp' => Carbon::now(),
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
            ]);
        });
    }

    /**
     * Get conversation between two users.
     */
    public function getConversation(int $userId1, int $userId2, int $perPage = 20): LengthAwarePaginator
    {
        return Message::where(function ($query) use ($userId1, $userId2) {
            $query->where('sender_id', $userId1)
                ->where('receiver_id', $userId2);
        })
        ->orWhere(function ($query) use ($userId1, $userId2) {
            $query->where('sender_id', $userId2)
                ->where('receiver_id', $userId1);
        })
        ->with('sender', 'receiver')
        ->orderBy('timestamp', 'asc')
        ->paginate($perPage);
    }

    /**
     * Inbox/Sent retrieval.
     */
    public function getInbox(int $userId, int $perPage = 20): LengthAwarePaginator
    {
        return Message::where('receiver_id', $userId)
            ->with('sender', 'receiver')
            ->orderBy('timestamp', 'desc')
            ->paginate($perPage);
    }

    public function getSentMessages(int $userId, int $perPage = 20): LengthAwarePaginator
    {
        return Message::where('sender_id', $userId)
            ->with('sender', 'receiver')
            ->orderBy('timestamp', 'desc')
            ->paginate($perPage);
    }

    /**
     * Message actions.
     */
    public function deleteMessage(int $messageId, int $userId): void
    {
        $message = Message::findOrFail($messageId);

        // Security check
        if ($message->sender_id !== $userId && $message->receiver_id !== $userId) {
            throw new \Exception("Unauthorized action.");
        }

        $message->delete();
    }

    public function getRecentConversations(int $userId, int $limit = 10): array
    {
        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with('sender', 'receiver')
            ->orderBy('timestamp', 'desc')
            ->get();

        $conversations = [];
        $seenContacts = [];

        foreach ($messages as $message) {
            $contactId = $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;

            if (!in_array($contactId, $seenContacts)) {
                $conversations[] = $message;
                $seenContacts[] = $contactId;

                if (count($conversations) >= $limit) {
                    break;
                }
            }
        }

        return $conversations;
    }
}
