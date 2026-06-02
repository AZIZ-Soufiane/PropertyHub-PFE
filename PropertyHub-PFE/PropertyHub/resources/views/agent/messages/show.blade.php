@extends('layouts.agent')

@section('title', 'Chat with ' . $user->name)

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
            <a href="{{ route('agent.messages.show', $user) }}"
                class="flex items-center gap-x-4 p-4 bg-white border-r-4 border-primary-500 hover:bg-gray-50 transition-all">
                <div class="size-10 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="grow min-w-0">
                    <h3 class="font-bold text-sm text-gray-800 truncate">{{ $user->name }}</h3>
                    <p class="text-xs text-gray-500 truncate font-medium">{{ $user->email }}</p>
                </div>
            </a>
        </div>
    </div>

    <div class="w-full lg:w-2/3 flex flex-col relative h-full">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white">
            <div class="flex items-center gap-x-4">
                <div class="size-10 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="font-black text-gray-800">{{ $user->name }}</h2>
                    <p class="text-xs font-bold text-gray-400">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <div class="p-6 overflow-y-auto flex-1 space-y-6 bg-gray-50/50">
            @forelse($messages as $msg)
                @php $mine = $msg->sender_id === auth()->id(); @endphp
                @if($mine)
                    <div class="flex gap-x-4 max-w-lg ms-auto justify-end">
                        <div class="bg-primary-500 rounded-2xl rounded-tr-none p-4 shadow-sm shadow-primary-500/20">
                            <p class="text-sm text-white font-medium whitespace-pre-wrap">{{ $msg->content }}</p>
                            <span class="text-[10px] text-primary-100 font-bold mt-2 block text-right">{{ $msg->created_at->format('h:i A') }}</span>
                        </div>
                        <div class="size-9 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                @else
                    <div class="flex gap-x-4 max-w-lg">
                        <div class="size-9 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-xs flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="bg-white border border-gray-100 rounded-2xl rounded-tl-none p-4 shadow-sm">
                            <p class="text-sm text-gray-800 font-medium whitespace-pre-wrap">{{ $msg->content }}</p>
                            <span class="text-[10px] text-gray-400 font-bold mt-2 block">{{ $msg->created_at->format('h:i A') }}</span>
                        </div>
                    </div>
                @endif
            @empty
                <div class="h-full flex items-center justify-center text-sm text-gray-500">No messages yet. Say hello!</div>
            @endforelse
        </div>

        <div class="p-6 bg-white border-t border-gray-100">
            <form action="{{ route('agent.messages.store') }}" method="POST" class="flex items-center gap-3">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                <div class="relative grow">
                    <input type="text" name="content" required
                        class="py-3 px-4 block w-full border border-gray-200 rounded-2xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all"
                        placeholder="Type your message...">
                </div>
                <button type="submit"
                    class="inline-flex flex-shrink-0 justify-center items-center size-12 rounded-2xl text-white transition-all shadow-lg shadow-primary-500/20 bg-primary-600 hover:bg-primary-700">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path d="m22 2-7 20-4-9-9-4Z" />
                        <path d="M22 2 11 13" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
