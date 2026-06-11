@extends('layouts.agent')

@section('title', 'Agent Dashboard')

@section('content')
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-800">Welcome back, {{ auth()->user()->name }}</h1>
        <p class="text-sm text-gray-500 mt-1">Here's what's happening today.</p>
    </div>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5">
        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Active Listings</p>
        <div class="flex items-center gap-x-3">
            <h3 class="text-3xl font-black text-gray-800">{{ $stats['active_listings'] }}</h3>
            @if($stats['new_this_week'] ?? 0)
                <span class="text-xs font-bold py-1 px-2 bg-emerald-100 text-emerald-800 rounded-lg">+{{ $stats['new_this_week'] }} new</span>
            @endif
        </div>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5">
        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Pending Viewings</p>
        <div class="flex items-center gap-x-3">
            <h3 class="text-3xl font-black text-gray-800">{{ $stats['pending_viewings'] }}</h3>
            <span class="text-xs font-bold py-1 px-2 bg-primary-100 text-primary-800 rounded-lg">Today</span>
        </div>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5">
        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Total Appointments</p>
        <div class="flex items-center gap-x-3">
            <h3 class="text-3xl font-black text-gray-800">{{ $stats['total_appointments'] }}</h3>
        </div>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5">
        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Unread Messages</p>
        <div class="flex items-center gap-x-3">
            <h3 class="text-3xl font-black text-gray-800">{{ $stats['unread_messages'] }}</h3>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-8">
    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Upcoming Appointments</h2>
            <a href="{{ route('agent.appointments.index') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700">View Calendar</a>
        </div>
        @forelse($upcomingAppointments as $appt)
            <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5 group hover:border-primary-300 transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div class="space-y-1">
                        <h3 class="font-bold text-gray-800 text-lg">{{ $appt->date_time->format('D, M d') }}</h3>
                        <p class="text-sm text-gray-500 font-medium">{{ $appt->date_time->format('H:i A') }} - {{ $appt->date_time->copy()->addHour()->format('H:i A') }}</p>
                    </div>
                    @php
                        $statusColors = [
                            'pending'   => 'bg-primary-100 text-primary-800',
                            'confirmed' => 'bg-emerald-100 text-emerald-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];
                        $statusColor = $statusColors[$appt->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-bold {{ $statusColor }}">{{ ucfirst($appt->status) }}</span>
                </div>
                <div class="mb-5 p-4 bg-gray-50 rounded-2xl">
                    <p class="text-sm text-gray-800 font-bold mb-1">{{ optional($appt->property)->title ?? 'Property deleted' }}</p>
                    <p class="text-xs text-gray-500 flex items-center gap-2">
                        <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        {{ optional($appt->client)->name ?? 'Unknown' }}
                    </p>
                </div>
                @if($appt->status === 'pending')
                    <div class="flex gap-x-2">
                        <form action="{{ route('agent.appointments.confirm', $appt) }}" method="POST" class="flex-1">
                            @csrf
                            <button class="w-full py-2.5 px-4 text-sm font-bold rounded-xl bg-emerald-500 text-white hover:bg-emerald-600 transition-colors">Accept</button>
                        </form>
                        <form action="{{ route('agent.appointments.cancel', $appt) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="button" @click="$store.confirm.ask('Cancel this appointment?', $el.closest('form'))"
                                    class="w-full py-2.5 px-4 text-sm font-bold rounded-xl border border-gray-200 bg-white text-red-600 hover:bg-red-50 transition-colors">Decline</button>
                        </form>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center text-sm text-gray-500">No upcoming appointments.</div>
        @endforelse
    </div>

    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Recent Messages</h2>
            <a href="{{ route('agent.messages.index') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700">Open Inbox</a>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="divide-y divide-gray-100">
                @forelse($recentMessages as $msg)
                    @php $sender = $msg->sender; @endphp
                    <a href="{{ route('agent.messages.show', $sender) }}"
                        class="flex items-center gap-x-4 p-4 hover:bg-gray-50 transition-colors group">
                        <div class="size-11 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold flex-shrink-0 group-hover:ring-2 ring-primary-500/50 transition-all">
                            {{ strtoupper(substr($sender->name ?? '?', 0, 1)) }}
                        </div>
                        <div class="grow min-w-0">
                            <div class="flex justify-between items-center mb-0.5">
                                <h4 class="text-sm font-bold text-gray-800 truncate">{{ $sender->name ?? 'Unknown' }}</h4>
                                <span class="text-[10px] font-medium text-gray-400 uppercase flex-shrink-0">{{ $msg->created_at->diffForHumans(null, true) }}</span>
                            </div>
                            <p class="text-xs text-gray-500 truncate">{{ $msg->content }}</p>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center text-sm text-gray-500">No messages yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-3xl overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <h2 class="text-lg font-bold text-gray-800">Recent Properties</h2>
        <div class="flex items-center gap-3">
            <a href="{{ route('agent.properties.index') }}"
                class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl bg-primary-600 text-white hover:bg-primary-700 transition-all shadow-sm whitespace-nowrap">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M12 4v16m8-8H4" />
                </svg>
                View All
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50/60">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Property</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Type</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Price</th>
                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentProperties as $property)
                    @php
                        $statusName = optional($property->statusRelation)->name ?? 'pending';
                        $pillMap = [
                            'approved' => 'bg-emerald-100 text-emerald-700',
                            'pending'  => 'bg-amber-100 text-amber-700',
                            'rejected' => 'bg-red-100 text-red-700',
                        ];
                        $pill = $pillMap[$statusName] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <img class="size-10 rounded-xl object-cover" src="{{ $property->image_url }}" alt="">
                                <div>
                                    <p class="text-sm font-bold text-gray-800">{{ $property->title }}</p>
                                    <p class="text-xs text-gray-400 font-medium">{{ $property->city }}, {{ $property->country }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ ucfirst($property->type) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="py-1 px-3 inline-flex items-center gap-1 rounded-full text-[10px] font-bold {{ $pill }} uppercase">
                                <span class="size-1.5 rounded-full bg-current"></span>{{ ucfirst($statusName) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">${{ number_format($property->price) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('properties.show', $property) }}"
                                    class="size-8 inline-flex justify-center items-center text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all" title="View">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>
                                <a href="{{ route('agent.properties.edit', $property) }}"
                                    class="size-8 inline-flex justify-center items-center text-gray-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                            No properties yet. <a href="{{ route('agent.properties.index') }}" class="text-primary-600 font-semibold">Manage your properties</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
        <p class="text-xs text-gray-400 font-semibold">Showing {{ $recentProperties->count() }} properties</p>
        <a href="{{ route('agent.properties.index') }}" class="text-xs font-bold text-primary-600 hover:text-primary-700">View all properties</a>
    </div>
</div>
@endsection
