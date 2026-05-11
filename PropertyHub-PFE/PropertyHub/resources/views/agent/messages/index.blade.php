@extends('layouts.agent')

@php
$conversations = $conversations ?? collect();
@endphp

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Messages</h1>
    <p class="text-sm text-gray-500 mt-1">Your conversations</p>
</div>

<div class="flex flex-col bg-white border border-gray-200 rounded-3xl overflow-hidden">
    @forelse($conversations as $conversation)
        <a href="{{ route('agent.messages.show', $conversation->sender ?? $conversation->receiver) }}" 
           class="flex items-center gap-4 p-4 hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-0">
            <div class="w-11 h-11 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600">
                {{ substr(($conversation->sender_id === Auth::id() ? $conversation->receiver : $conversation->sender)->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-center">
                    <h4 class="text-sm font-bold text-gray-800">
                        {{ ($conversation->sender_id === Auth::id() ? $conversation->receiver : $conversation->sender)->name }}
                    </h4>
                    <span class="text-[10px] font-medium text-gray-400">{{ $conversation->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-xs text-gray-500 truncate">{{ $conversation->content }}</p>
            </div>
        </a>
    @empty
        <div class="p-8 text-center">
            <p class="text-gray-500">No messages yet</p>
        </div>
    @endforelse
</div>
@endsection