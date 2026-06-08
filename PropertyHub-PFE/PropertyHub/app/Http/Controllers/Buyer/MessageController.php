<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct(private MessageService $messageService) {}

    public function index()
    {
        $conversations = $this->messageService->getRecentConversations(Auth::id(), 'buyer');
        return view('buyer.messages.index', compact('conversations'));
    }

    public function show(User $user)
    {
        abort_unless($this->messageService->canConversate(Auth::id(), 'buyer', $user->id), 403);

        $this->messageService->markConversationAsRead(Auth::id(), $user->id);
        $messages = $this->messageService->getConversation(Auth::id(), $user->id);

        return view('buyer.messages.show', compact('user', 'messages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content'     => 'required|string',
        ]);

        abort_unless($this->messageService->canConversate(Auth::id(), 'buyer', (int) $validated['receiver_id']), 403);

        $this->messageService->sendMessage(Auth::id(), (int) $validated['receiver_id'], $validated['content']);

        return back();
    }
}
