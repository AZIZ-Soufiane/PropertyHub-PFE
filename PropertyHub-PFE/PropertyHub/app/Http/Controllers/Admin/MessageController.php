<?php

namespace App\Http\Controllers\Admin;

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
        $conversations = $this->messageService->getRecentConversations(Auth::id());
        return view('admin.messages.index', compact('conversations'));
    }

    public function show(User $user)
    {
        $this->messageService->markConversationAsRead(Auth::id(), $user->id);
        $messages = $this->messageService->getConversation(Auth::id(), $user->id);

        return view('admin.messages.show', compact('user', 'messages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content'     => 'required|string',
        ]);

        $this->messageService->sendMessage(Auth::id(), (int) $validated['receiver_id'], $validated['content']);

        return back();
    }
}
