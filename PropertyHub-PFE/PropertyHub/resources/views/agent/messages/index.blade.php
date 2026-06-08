@extends('layouts.agent')

@section('title', 'Messages')

@section('content')
<div class="flex flex-col lg:flex-row h-[calc(100vh-200px)] gap-0 bg-white border border-gray-200 rounded-3xl overflow-hidden shadow-sm">
    <div class="w-full lg:w-1/3 border-r border-gray-100 flex flex-col bg-gray-50/30">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-black text-gray-800 mb-4">Conversations</h2>
            <div class="relative">
                <input type="text"
                    class="py-2.5 px-4 ps-11 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all"
                    placeholder="Search messages">
                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                    <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="overflow-y-auto flex-1">
            @forelse($conversations as $conv)
                @php
                    $other = $conv->contact;
                    $msg = $conv->latest_message;
                @endphp
                <a href="{{ route('agent.messages.show', $other) }}"
                    class="flex items-center gap-4 p-4 hover:bg-white transition-all border-l-4 border-transparent hover:border-primary-500">
                    <div class="size-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr($other->name ?? '?', 0, 1)) }}
                    </div>
                    <div class="grow min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="font-bold text-sm text-gray-800 truncate">{{ $other->name ?? 'Unknown' }}</h3>
                            @if($msg)
                                <span class="text-[10px] text-gray-400 font-bold whitespace-nowrap">{{ $msg->created_at->diffForHumans(null, true) }}</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 truncate font-medium">{{ $msg ? $msg->content : 'Start a conversation' }}</p>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center text-sm text-gray-500">No conversations yet.</div>
            @endforelse
        </div>
    </div>

    <div class="w-full lg:w-2/3 flex flex-col items-center justify-center bg-gray-50/50">
        <div class="text-center px-6">
            <div class="w-16 h-16 rounded-2xl bg-primary-100 text-primary-600 flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                </svg>
            </div>
            <h2 class="font-black text-gray-800">Select a conversation</h2>
            <p class="text-sm text-gray-500 mt-1">Choose a client on the left to read your messages.</p>
        </div>
    </div>
</div>
@endsection
