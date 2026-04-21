@extends('layouts.agent')

@php
$otherUser = $user;
@endphp

@section('content')
<div class="mb-8">
    <a href="{{ route('agent.messages.index') }}" class="text-sm text-blue-600 hover:underline">← Back to Messages</a>
</div>

<div class="bg-white border border-gray-200 rounded-3xl overflow-hidden" style="height: calc(100vh - 200px);">
    <div class="h-full flex flex-col">
        <!-- Chat Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600">
                {{ substr($otherUser->name, 0, 1) }}
            </div>
            <div>
                <h2 class="font-bold text-gray-800">{{ $otherUser->name }}</h2>
                <p class="text-xs text-gray-400">{{ $otherUser->email }}</p>
            </div>
        </div>
        
        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-6 space-y-4">
            @forelse($messages as $message)
                <div class="flex {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-md {{ $message->sender_id === Auth::id() ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800' }} rounded-2xl px-4 py-3">
                        <p>{{ $message->content }}</p>
                        <p class="text-[10px] mt-1 {{ $message->sender_id === Auth::id() ? 'text-blue-200' : 'text-gray-400' }}">
                            {{ $message->created_at->format('M d, H:i') }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">No messages yet. Start the conversation!</p>
            @endforelse
        </div>
        
        <!-- Send Message -->
        <form action="{{ route('agent.messages.store') }}" method="POST" class="p-4 border-t border-gray-100 flex gap-3">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
            <input type="text" name="content" placeholder="Type your message..." required
                class="flex-1 py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500">
            <button type="submit" class="py-3 px-6 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700">Send</button>
        </form>
    </div>
</div>
@endsection