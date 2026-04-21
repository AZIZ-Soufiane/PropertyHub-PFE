<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = Message::with('sender')
            ->where('receiver_id', Auth::id())
            ->orWhere('sender_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(fn($m) => $m->sender_id === Auth::id() ? $m->receiver_id : $m->sender_id)
            ->map(fn($msgs) => $msgs->first());
            
        return view('agent.messages.index', compact('conversations'));
    }

    public function show(User $user)
    {
        $messages = Message::where(fn($q) => $q
            ->where('sender_id', Auth::id())->where('receiver_id', $user->id)
        )->orWhere(fn($q2) => $q2->where('sender_id', $user->id)->where('receiver_id', Auth::id())
        )->update(['read_at' => now()]);
        
        $messages = Message::with('sender')
            ->where(fn($q) => $q
                ->where('sender_id', Auth::id())->where('receiver_id', $user->id)
            )->orWhere(fn($q2) => $q2->where('sender_id', $user->id)->where('receiver_id', Auth::id())
            )
            ->orderBy('created_at')
            ->get();
            
        return view('agent.messages.show', compact('user', 'messages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);
        
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $validated['receiver_id'],
            'content' => $validated['content'],
        ]);
        
        return back();
    }
}