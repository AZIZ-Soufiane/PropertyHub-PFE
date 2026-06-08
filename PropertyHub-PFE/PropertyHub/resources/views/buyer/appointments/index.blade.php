@extends('layouts.buyer')

@section('title', 'My Appointments')

@section('content')
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-800">My Appointments</h1>
        <p class="text-sm text-gray-500 mt-1">Track the status of all your property viewings.</p>
    </div>
</div>

<div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-3xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50/60">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Property</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Agent</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Date & Time</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($appointments as $appt)
                    @php
                        $pillMap = [
                            'pending'   => 'bg-amber-100 text-amber-700',
                            'confirmed' => 'bg-emerald-100 text-emerald-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                            'scheduled' => 'bg-blue-100 text-blue-700',
                        ];
                        $pill = $pillMap[$appt->status] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-bold text-gray-800">{{ optional($appt->property)->title ?? 'Property deleted' }}</p>
                            <p class="text-xs text-gray-400">{{ optional($appt->property)->city }}, {{ optional($appt->property)->country }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($appt->agent)
                                <div class="flex items-center gap-2">
                                    <span class="size-7 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-xs">{{ strtoupper(substr($appt->agent->name, 0, 1)) }}</span>
                                    <span class="text-sm text-gray-700 font-medium">{{ $appt->agent->name }}</span>
                                </div>
                            @else
                                <span class="text-sm text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-medium text-gray-800">{{ $appt->date_time->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $appt->date_time->format('H:i') }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="py-1 px-3 inline-flex items-center gap-1 rounded-full text-[10px] font-bold {{ $pill }} uppercase">
                                <span class="size-1.5 rounded-full bg-current"></span>{{ ucfirst($appt->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            @if($appt->agent)
                                <a href="{{ route('buyer.messages.show', $appt->agent) }}"
                                    class="inline-flex items-center gap-1.5 py-1.5 px-3 text-xs font-bold rounded-lg bg-primary-50 text-primary-600 hover:bg-primary-100 transition-colors">
                                    <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                    Message Agent
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                            No appointments yet. <a href="{{ route('properties.index') }}" class="text-primary-600 font-semibold">Browse properties</a> to book one.
                        </td>
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
