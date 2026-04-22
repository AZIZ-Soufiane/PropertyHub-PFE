@extends('layouts.agent')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Welcome back, {{ Auth::user()->name }}</h1>
        <p class="text-sm text-gray-500 mt-1">Here's what's happening with your listings.</p>
    </div>
    <a href="{{ route('agent.properties.create') }}" 
       class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path d="M12 4v16m8-8H4" />
        </svg>
        Add Property
    </a>
</div>

<!-- Stats -->
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5">
        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Active Listings</p>
        <div class="flex items-center gap-x-3">
            <h3 class="text-3xl font-black text-gray-800">{{ $stats['active_listings'] ?? 0 }}</h3>
            @if(($stats['new_this_week'] ?? 0) > 0)
                <span class="text-xs font-bold py-1 px-2 bg-emerald-100 text-emerald-800 rounded-lg">+{{ $stats['new_this_week'] }} new</span>
            @endif
        </div>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5">
        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Pending Viewings</p>
        <div class="flex items-center gap-x-3">
            <h3 class="text-3xl font-black text-gray-800">{{ $stats['pending_viewings'] ?? 0 }}</h3>
            <span class="text-xs font-bold py-1 px-2 bg-blue-100 text-blue-800 rounded-lg">Today</span>
        </div>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5">
        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Total Appointments</p>
        <div class="flex items-center gap-x-3">
            <h3 class="text-3xl font-black text-gray-800">{{ $stats['total_appointments'] ?? 0 }}</h3>
        </div>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5">
        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Unread Messages</p>
        <div class="flex items-center gap-x-3">
            <h3 class="text-3xl font-black text-gray-800">{{ $stats['unread_messages'] ?? 0 }}</h3>
        </div>
    </div>
</div>

<!-- Two Column Layout -->
<div class="grid lg:grid-cols-2 gap-8">
    <!-- Upcoming Appointments -->
    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Upcoming Appointments</h2>
            <a href="{{ route('agent.appointments.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">View Calendar</a>
        </div>
        
        @forelse($upcomingAppointments ?? [] as $appointment)
            <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5 hover:border-blue-300 transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div class="space-y-1">
                        <h3 class="font-bold text-gray-800 text-lg">{{ $appointment->scheduled_at->format('D, M d') }}</h3>
                        <p class="text-sm text-gray-500 font-medium">{{ $appointment->time_slot }}</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-bold 
                        {{ $appointment->status === 'confirmed' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>
                <div class="mb-5 p-4 bg-gray-50 rounded-2xl">
                    <p class="text-sm text-gray-800 font-bold mb-1">{{ $appointment->property->title }}</p>
                    <p class="text-xs text-gray-500 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        {{ $appointment->client->name }}
                    </p>
                </div>
                <div class="flex gap-x-2">
                    @if($appointment->status === 'pending')
                        <form action="{{ route('agent.appointments.confirm', $appointment) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-2.5 px-4 text-sm font-bold rounded-xl bg-emerald-500 text-white hover:bg-emerald-600 transition-colors">
                                Accept
                            </button>
                        </form>
                        <form action="{{ route('agent.appointments.cancel', $appointment) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-2.5 px-4 text-sm font-bold rounded-xl border border-gray-200 bg-white text-rose-600 hover:bg-rose-50 transition-colors">
                                Decline
                            </button>
                        </form>
                    @else
                        <a href="{{ route('agent.appointments.show', $appointment) }}" class="flex-1 py-2.5 px-4 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 text-center transition-colors">
                            View Details
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center">
                <p class="text-gray-500">No upcoming appointments</p>
            </div>
        @endforelse
    </div>

    <!-- Recent Messages -->
    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Recent Messages</h2>
            <a href="{{ route('agent.messages.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Open Inbox</a>
        </div>
        
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            @forelse($recentMessages ?? [] as $message)
                <a href="{{ route('agent.messages.show', $message->sender) }}" 
                   class="flex items-center gap-4 p-4 hover:bg-gray-50 transition-colors group border-b border-gray-100 last:border-0">
                    <div class="w-11 h-11 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-600">
                        {{ substr($message->sender->name, 0, 1) }}
                    </div>
                    <div class="grow">
                        <div class="flex justify-between items-center">
                            <h4 class="text-sm font-bold text-gray-800">{{ $message->sender->name }}</h4>
                            <span class="text-[10px] font-medium text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-gray-500 line-clamp-1">{{ $message->content }}</p>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center">
                    <p class="text-gray-500">No messages yet</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Recent Properties Table -->
<div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-3xl overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <h2 class="text-xl font-bold text-gray-800">My Recent Listings</h2>
        <a href="{{ route('agent.properties.index') }}" 
           class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path d="M12 4v16m8-8H4" />
            </svg>
            View All
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50/60">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Property</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Price</th>
                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentProperties ?? [] as $property)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <img class="w-10 h-10 rounded-xl object-cover" 
                                     src="{{ $property->images->first()?->first_url ?? 'https://via.placeholder.com/80' }}" alt="">
                                <div>
                                    <p class="text-sm font-bold text-gray-800">{{ $property->title }}</p>
                                    <p class="text-xs text-gray-400 font-medium">{{ $property->city }}, {{ $property->country }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="py-1 px-3 inline-flex items-center gap-1 rounded-full text-[10px] font-bold 
                                {{ $property->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $property->status === 'approved' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                {{ ucfirst($property->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">${{ number_format($property->price) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('properties.show', $property) }}" 
                                   class="w-8 h-8 inline-flex justify-center items-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>
                                <a href="{{ route('agent.properties.edit', $property) }}" 
                                   class="w-8 h-8 inline-flex justify-center items-center text-gray-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">No properties yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection