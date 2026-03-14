<?php

namespace App\Services\Public;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessageService
{
    /**
     * Send a message between users.
     * 
     * @param int $senderId
     * @param int $receiverId
     * @param string $content
     * @return Message
     */
    public function sendMessage(int $senderId, int $receiverId, string $content): Message
    {
        return DB::transaction(function () use ($senderId, $receiverId, $content) {
            // Verify both users exist
            User::findOrFail($senderId);
            User::findOrFail($receiverId);

            // Prevent self-messaging
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
     * 
     * @param int $userId1
     * @param int $userId2
     * @param int $perPage
     * @return mixed
     */
    public function getConversation(int $userId1, int $userId2, int $perPage = 20)
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
     * Get user's inbox (received messages).
     * 
     * @param int $userId
     * @param int $perPage
     * @return mixed
     */
    public function getInbox(int $userId, int $perPage = 20)
    {
        return Message::where('receiver_id', $userId)
            ->with('sender', 'receiver')
            ->orderBy('timestamp', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get user's sent messages.
     * 
     * @param int $userId
     * @param int $perPage
     * @return mixed
     */
    public function getSentMessages(int $userId, int $perPage = 20)
    {
        return Message::where('sender_id', $userId)
            ->with('sender', 'receiver')
            ->orderBy('timestamp', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get message details.
     * 
     * @param int $messageId
     * @return Message
     */
    public function getMessageDetails(int $messageId): Message
    {
        return Message::with('sender', 'receiver')
            ->findOrFail($messageId);
    }

    /**
     * Delete a message.
     * 
     * @param int $messageId
     * @param int $userId
     * @return void
     */
    public function deleteMessage(int $messageId, int $userId): void
    {
        $message = Message::findOrFail($messageId);

        // Only sender or receiver can delete
        if ($message->sender_id !== $userId && $message->receiver_id !== $userId) {
            throw new \Exception("Unauthorized action.");
        }

        $message->delete();
    }

    /**
     * Get recent conversations for a user.
     * 
     * @param int $userId
     * @param int $limit
     * @return array
     */
    public function getRecentConversations(int $userId, int $limit = 10): array
    {
        // Get recent message with each unique contact
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

    /**
     * Count unread messages for a user.
     * 
     * @param int $userId
     * @return int
     */
    public function countUnreadMessages(int $userId): int
    {
        // If you add a 'read' column to messages table, implement like this:
        // return Message::where('receiver_id', $userId)->where('read', false)->count();
        return Message::where('receiver_id', $userId)->count();
    }
}
