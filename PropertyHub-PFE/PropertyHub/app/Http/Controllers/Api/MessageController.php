<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(private MessageService $messageService)
    {
    }

    /**
     * Get all messages for the authenticated user
     */
    public function index(Request $request): JsonResponse
    {
        $userId = auth()->id();
        $perPage = $request->get('per_page', 15);

        $messages = \App\Models\Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with('sender', 'receiver')
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => MessageResource::collection($messages),
            'meta' => [
                'current_page' => $messages->currentPage(),
                'per_page' => $messages->perPage(),
                'total' => $messages->total(),
                'last_page' => $messages->lastPage(),
            ]
        ]);
    }

    /**
     * Get conversations list
     */
    public function getConversations(Request $request): JsonResponse
    {
        $userId = auth()->id();
        $perPage = $request->get('per_page', 15);

        // Get unique conversations with latest message
        $conversations = \App\Models\Message::where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
        })
        ->with('sender', 'receiver')
        ->latest()
        ->get()
        ->groupBy(function ($message) use ($userId) {
            return $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
        })
        ->take($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $conversations,
        ]);
    }

    /**
     * Get conversation with a specific user
     */
    public function getConversation(int $userId, Request $request): JsonResponse
    {
        $authUserId = auth()->id();
        $perPage = $request->get('per_page', 50);

        $messages = \App\Models\Message::where(function ($query) use ($authUserId, $userId) {
            $query->where('sender_id', $authUserId)
                  ->where('receiver_id', $userId);
        })
        ->orWhere(function ($query) use ($authUserId, $userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $authUserId);
        })
        ->with('sender', 'receiver')
        ->latest()
        ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => MessageResource::collection($messages),
            'meta' => [
                'current_page' => $messages->currentPage(),
                'per_page' => $messages->perPage(),
                'total' => $messages->total(),
                'last_page' => $messages->lastPage(),
            ]
        ]);
    }

    /**
     * Get inbox messages
     */
    public function getInbox(Request $request): JsonResponse
    {
        $userId = auth()->id();
        $perPage = $request->get('per_page', 15);

        $messages = \App\Models\Message::where('receiver_id', $userId)
            ->with('sender', 'receiver')
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => MessageResource::collection($messages),
            'meta' => [
                'current_page' => $messages->currentPage(),
                'per_page' => $messages->perPage(),
                'total' => $messages->total(),
                'last_page' => $messages->lastPage(),
            ]
        ]);
    }

    /**
     * Get sent messages
     */
    public function getSentMessages(Request $request): JsonResponse
    {
        $userId = auth()->id();
        $perPage = $request->get('per_page', 15);

        $messages = \App\Models\Message::where('sender_id', $userId)
            ->with('sender', 'receiver')
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => MessageResource::collection($messages),
            'meta' => [
                'current_page' => $messages->currentPage(),
                'per_page' => $messages->perPage(),
                'total' => $messages->total(),
                'last_page' => $messages->lastPage(),
            ]
        ]);
    }

    /**
     * Send a message
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|min:1',
        ]);

        try {
            $senderId = auth()->id();
            $message = \App\Models\Message::create([
                'sender_id' => $senderId,
                'receiver_id' => $request->get('receiver_id'),
                'content' => $request->get('content'),
            ]);

            $message->load('sender', 'receiver');

            return response()->json([
                'status' => 'success',
                'message' => 'Message sent successfully',
                'data' => new MessageResource($message),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Delete a message
     */
    public function destroy(int $messageId): JsonResponse
    {
        try {
            $userId = auth()->id();
            $message = \App\Models\Message::findOrFail($messageId);

            // Only sender or receiver can delete
            if ($message->sender_id !== $userId && $message->receiver_id !== $userId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized action',
                ], 403);
            }

            $message->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Message deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
