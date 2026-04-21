@extends('layouts.agent')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Appointments</h1>
    <p class="text-sm text-gray-500 mt-1">Manage your property viewings</p>
</div>

<div class="flex flex-col bg-white border border-gray-200 rounded-3xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50/60">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Property</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Client</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Date & Time</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($appointments as $appointment)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('properties.show', $appointment->property) }}" class="text-sm font-bold text-gray-800 hover:text-blue-600">
                                {{ $appointment->property->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $appointment->client->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-bold text-gray-800">{{ $appointment->scheduled_at->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $appointment->time_slot }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="py-1 px-3 rounded-full text-[10px] font-bold
                                {{ $appointment->status === 'confirmed' ? 'bg-emerald-100 text-emerald-700' : ($appointment->status === 'pending' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            @if($appointment->status === 'pending')
                                <form action="{{ route('agent.appointments.confirm', $appointment) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="py-1.5 px-3 text-xs font-bold bg-emerald-500 text-white rounded-lg hover:bg-emerald-600">Accept</button>
                                </form>
                                <form action="{{ route('agent.appointments.cancel', $appointment) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="py-1.5 px-3 text-xs font-bold border border-gray-200 text-rose-600 rounded-lg hover:bg-rose-50">Decline</button>
                                </form>
                            @else
                                <a href="{{ route('agent.appointments.show', $appointment) }}" class="text-xs text-blue-600 hover:underline">View</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">No appointments yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($appointments->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $appointments->links() }}
        </div>
    @endif
</div>
@endsection