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
        $conversations = $this->messageService->getAllowedContacts(Auth::id(), 'admin');
        return view('admin.messages.index', compact('conversations'));
    }

    public function show(User $user)
    {
        $this->messageService->markConversationAsRead(Auth::id(), $user->id);
        $messages = $this->messageService->getConversation(Auth::id(), $user->id);
        $conversations = $this->messageService->getAllowedContacts(Auth::id(), 'admin');

        return view('admin.messages.show', compact('user', 'messages', 'conversations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content'     => 'required|string',
        ]);

        abort_unless($this->messageService->canConversate(Auth::id(), 'admin', (int) $validated['receiver_id']), 403);

        $this->messageService->sendMessage(Auth::id(), (int) $validated['receiver_id'], $validated['content']);

        return back();
    }
}
