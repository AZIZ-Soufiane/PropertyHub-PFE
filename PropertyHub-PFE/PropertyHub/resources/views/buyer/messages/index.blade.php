@extends('layouts.buyer')

@section('title', 'Messages')

@section('content')
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-800">My Messages</h1>
        <p class="text-sm text-gray-500 mt-1">Conversations with agents.</p>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
    <div class="divide-y divide-gray-100">
        @forelse($conversations as $conv)
            @php 
                $contact = $conv->contact;
                $msg = $conv->latest_message;
            @endphp
            <a href="{{ route('buyer.messages.show', $contact) }}"
                class="flex items-center gap-x-4 p-5 hover:bg-gray-50 transition-colors group">
                <div class="size-12 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold flex-shrink-0 group-hover:ring-2 ring-primary-500/50 transition-all">
                    {{ strtoupper(substr($contact->name ?? '?', 0, 1)) }}
                </div>
                <div class="grow min-w-0">
                    <div class="flex justify-between items-center mb-1">
                        <h4 class="text-sm font-bold text-gray-800 truncate">{{ $contact->name ?? 'Unknown' }}</h4>
                        @if($msg)
                            <span class="text-[10px] font-medium text-gray-400 uppercase flex-shrink-0">{{ $msg->created_at->diffForHumans(null, true) }}</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 truncate">
                        @if($msg && $msg->sender_id === auth()->id()) <span class="text-gray-400">You:</span> @endif
                        {{ $msg ? $msg->content : 'Start a conversation' }}
                    </p>
                </div>
                <svg class="size-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        @empty
            <div class="p-12 text-center">
                <svg class="size-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <p class="text-sm font-medium text-gray-500">No conversations yet.</p>
                <p class="text-xs text-gray-400 mt-1">Book an appointment and message the agent directly.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
