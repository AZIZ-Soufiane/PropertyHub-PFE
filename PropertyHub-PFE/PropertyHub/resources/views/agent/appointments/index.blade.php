@extends('layouts.agent')

@section('title', 'Appointments')

@section('content')
<div class="bg-white border border-gray-200 shadow-sm rounded-3xl overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex-1 flex items-center gap-3 w-full">
            <div class="relative flex-1 max-w-sm">
                <input type="text"
                    class="py-2.5 px-4 ps-11 block w-full border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all border"
                    placeholder="Search appointments...">
                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                    <svg class="size-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="m21 21-4.3-4.3" />
                        <circle cx="10" cy="10" r="7" />
                    </svg>
                </div>
            </div>
            <select class="py-2.5 ps-4 pe-9 flex text-nowrap w-48 cursor-pointer bg-white border border-gray-200 text-gray-800 rounded-xl text-start text-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50/60">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Client</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Property</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Date & Time</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($appointments as $appt)
                    @php
                        $st = $appt->status;
                        $map = [
                            'pending'   => 'bg-amber-100 text-amber-700',
                            'scheduled' => 'bg-blue-100 text-blue-700',
                            'confirmed' => 'bg-emerald-100 text-emerald-700',
                            'completed' => 'bg-teal-100 text-teal-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                        ];
                        $pill = $map[$st] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">{{ optional($appt->client)->name ?? 'Unknown' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($appt->property)->title ?? 'Deleted property' }}{{ optional($appt->property)->city ? ', ' . optional($appt->property)->city : '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                            {{ $appt->date_time->format('M d, Y') }} - {{ $appt->date_time->format('h:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="py-1 px-3 inline-flex items-center gap-1 rounded-full text-[10px] font-bold {{ $pill }} uppercase">
                                <span class="size-1.5 rounded-full bg-current"></span>{{ ucfirst($st) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('agent.appointments.show', $appt) }}"
                                    class="py-1.5 px-3 bg-white border border-gray-200 text-gray-600 rounded-lg text-xs font-bold hover:bg-gray-50">Review</a>
                                @if(in_array($appt->status, ['pending', 'scheduled']))
                                    <form action="{{ route('agent.appointments.confirm', $appt) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="py-1.5 px-3 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold hover:bg-emerald-200">Accept</button>
                                    </form>
                                @endif
                                @if($appt->status !== 'cancelled')
                                    <form action="{{ route('agent.appointments.cancel', $appt) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this appointment?')">
                                        @csrf
                                        <button class="py-1.5 px-3 bg-red-100 text-red-700 rounded-lg text-xs font-bold hover:bg-red-200">Decline</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">No appointments yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Calendar --}}
<div class="mt-8 bg-white border border-gray-200 shadow-sm rounded-3xl overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-sm font-black text-gray-700 uppercase tracking-widest">Calendar</h3>
        <div class="flex items-center gap-3">
            <a href="{{ route('agent.appointments.index', ['year' => $calendar['prevMonth']->year, 'month' => $calendar['prevMonth']->month]) }}"
               class="size-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 transition-colors">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <span class="text-sm font-bold text-gray-700 min-w-[140px] text-center">{{ $calendar['monthName'] }} {{ $calendar['year'] }}</span>
            <a href="{{ route('agent.appointments.index', ['year' => $calendar['nextMonth']->year, 'month' => $calendar['nextMonth']->month]) }}"
               class="size-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 transition-colors">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-7 mb-2">
            @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $d)
                <div class="text-center text-[10px] font-black text-gray-400 uppercase tracking-widest py-1">{{ $d }}</div>
            @endforeach
        </div>
        <div class="grid grid-cols-7 gap-2">
            @php
                $totalCells = $calendar['startDow'] + $calendar['daysInMonth'];
                $totalCells = ceil($totalCells / 7) * 7;
            @endphp
            @for($i = 0; $i < $totalCells; $i++)
                @php
                    $cellDay = $i - $calendar['startDow'] + 1;
                    $isValid = $cellDay >= 1 && $cellDay <= $calendar['daysInMonth'];
                    $dateKey = $isValid ? sprintf('%04d-%02d-%02d', $calendar['year'], $calendar['month'], $cellDay) : null;
                    $hasAppts = $dateKey && isset($calendar['appointments'][$dateKey]);
                    $apptCount = $hasAppts ? $calendar['appointments'][$dateKey]->count() : 0;
                    $isToday = $isValid && $dateKey === now()->format('Y-m-d');
                    $isSelected = $isValid && $dateKey === $calDate;
                @endphp
                <div class="p-0.5 min-h-[145px]">
                    @if($isValid)
                        <div class="size-full p-2.5 bg-slate-50/50 border border-slate-200 rounded-2xl flex flex-col justify-between transition-all {{ $isToday ? 'ring-2 ring-primary-500 bg-white' : '' }} {{ $isSelected ? 'ring-2 ring-primary-600 bg-white shadow-md' : '' }}">
                            <div class="flex justify-between items-center mb-2">
                                <a href="{{ route('agent.appointments.index', ['year' => $calendar['year'], 'month' => $calendar['month'], 'cal_date' => $dateKey]) }}"
                                   class="text-xs font-black py-0.5 px-2 rounded-lg transition-all {{ $isToday ? 'bg-primary-500 text-white' : 'text-slate-500 hover:bg-slate-100' }}">
                                    {{ $cellDay }}
                                </a>
                                @if($apptCount > 0)
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-tight">{{ $apptCount }} {{ Str::plural('Meet', $apptCount) }}</span>
                                @endif
                            </div>
                            <div class="flex-1 space-y-1.5 overflow-y-auto max-h-[105px] pr-0.5">
                                @if($hasAppts)
                                    @foreach($calendar['appointments'][$dateKey] as $appt)
                                        @php
                                            $c = match($appt->status) {
                                                'pending' => 'bg-amber-50 text-amber-800 border-amber-200 hover:bg-amber-100/80',
                                                'scheduled' => 'bg-blue-50 text-blue-800 border-blue-200 hover:bg-blue-100/80',
                                                'confirmed' => 'bg-emerald-50 text-emerald-800 border-emerald-200 hover:bg-emerald-100/80',
                                                'completed' => 'bg-teal-50 text-teal-800 border-teal-200 hover:bg-teal-100/80',
                                                'cancelled' => 'bg-rose-50 text-rose-800 border-rose-200 hover:bg-rose-100/80',
                                                default => 'bg-slate-50 text-slate-800 border-slate-200 hover:bg-slate-100/80',
                                            };
                                        @endphp
                                        <a href="{{ route('agent.appointments.show', $appt) }}"
                                           class="block p-1.5 rounded-xl border text-[9px] font-bold leading-tight transition-all truncate {{ $c }}"
                                           title="{{ $appt->date_time->format('h:i A') }} - {{ optional($appt->client)->name }}: {{ optional($appt->property)->title }}">
                                            <span class="block font-black opacity-80">{{ $appt->date_time->format('h:i A') }}</span>
                                            <span class="block truncate">{{ optional($appt->client)->name }}</span>
                                            <span class="block truncate opacity-75 font-semibold text-[8px]">{{ optional($appt->property)->title }}</span>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="size-full bg-slate-50/10 border border-transparent rounded-2xl"></div>
                    @endif
                </div>
            @endfor
        </div>

        {{-- Appointments for selected date --}}
        @if($calDate)
            <div class="mt-6 border-t border-gray-100 pt-4">
                <h4 class="text-xs font-black text-gray-500 uppercase tracking-widest mb-3">Appointments for {{ $calDate }}</h4>
                @forelse($selectedDateAppts as $appt)
                    <div class="flex items-center justify-between py-3 px-4 rounded-xl hover:bg-gray-50 transition-colors border border-gray-100 mb-2">
                        <div class="flex items-start gap-4">
                            <div class="text-center min-w-[60px]">
                                <p class="text-sm font-black text-gray-700">{{ $appt->date_time->format('h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ optional($appt->client)->name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-400">{{ optional($appt->client)->email ?? '' }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ optional($appt->property)->title ?? 'Deleted' }}
                                    @if(optional($appt->property)->city) — {{ $appt->property->city }} @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <span class="py-0.5 px-2 rounded-full text-[9px] font-bold uppercase whitespace-nowrap
                                {{ match($appt->status) {
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'scheduled' => 'bg-blue-100 text-blue-700',
                                    'confirmed' => 'bg-emerald-100 text-emerald-700',
                                    'completed' => 'bg-teal-100 text-teal-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                } }}">{{ $appt->status }}</span>
                            <a href="{{ route('agent.appointments.show', $appt) }}"
                               class="text-xs font-bold text-primary-500 hover:text-primary-600 transition-colors whitespace-nowrap">View Details</a>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 py-2">No appointments this day.</p>
                @endforelse
            </div>
        @endif
    </div>
</div>
@endsection
