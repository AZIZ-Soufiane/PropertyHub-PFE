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
@php
    $calQuery = array_filter(request()->query(), fn($k) => !in_array($k, ['cal_date']), ARRAY_FILTER_USE_KEY);
@endphp
<div class="mt-8 bg-white border border-slate-200/80 shadow-xl shadow-slate-100 rounded-3xl overflow-hidden transition-all duration-300">
    <!-- Header with premium gradient -->
    <div class="px-6 py-5 bg-gradient-to-r from-slate-900 via-indigo-950 to-primary-950 text-white flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="size-10 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20">
                <svg class="size-5 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-black uppercase tracking-widest leading-none">Appointment schedule</h3>
                <span class="text-[10px] text-slate-300 font-bold uppercase mt-1 block">Monthly Calendar & Meetings</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('agent.appointments.index', array_merge($calQuery, ['year' => $calendar['prevMonth']->year, 'month' => $calendar['prevMonth']->month])) }}"
               class="size-9 flex items-center justify-center rounded-xl bg-white/10 hover:bg-white/20 text-white border border-white/10 transition-all hover:scale-105 active:scale-95 shadow-inner">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <span class="text-sm font-black min-w-[140px] text-center bg-white/5 backdrop-blur-md py-1.5 px-4 rounded-xl border border-white/10 tracking-wide">{{ $calendar['monthName'] }} {{ $calendar['year'] }}</span>
            <a href="{{ route('agent.appointments.index', array_merge($calQuery, ['year' => $calendar['nextMonth']->year, 'month' => $calendar['nextMonth']->month])) }}"
               class="size-9 flex items-center justify-center rounded-xl bg-white/10 hover:bg-white/20 text-white border border-white/10 transition-all hover:scale-105 active:scale-95 shadow-inner">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <div class="p-6 bg-slate-50/30">
        <!-- Weekdays header -->
        <div class="grid grid-cols-7 gap-3 mb-3">
            @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $d)
                <div class="text-center text-[10px] font-black text-slate-400 uppercase tracking-widest py-1">{{ $d }}</div>
            @endforeach
        </div>

        <!-- Days Grid -->
        <div class="grid grid-cols-7 gap-3">
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
                <div class="min-h-[145px]">
                    @if($isValid)
                        <div class="group size-full p-2.5 bg-white border rounded-2xl flex flex-col justify-between transition-all duration-300 hover:shadow-lg hover:shadow-slate-100 hover:border-slate-300 hover:-translate-y-0.5
                            {{ $isToday ? 'bg-gradient-to-br from-primary-50/40 to-indigo-50/40 border-primary-300/80 shadow-md shadow-primary-500/5 ring-2 ring-primary-500/10' : 'border-slate-200/90' }}
                            {{ $isSelected && !$isToday ? 'border-slate-400 ring-2 ring-primary-500/10 bg-slate-50/30' : '' }}">
                            <div class="flex justify-between items-center mb-2">
                                <a href="{{ route('agent.appointments.index', array_merge($calQuery, ['year' => $calendar['year'], 'month' => $calendar['month'], 'cal_date' => $dateKey])) }}"
                                   class="inline-flex items-center justify-center size-7 rounded-xl text-xs font-black transition-all
                                          {{ $isToday ? 'bg-primary-500 text-white shadow-lg shadow-primary-500/25 hover:bg-primary-600' : 'text-slate-700 hover:bg-slate-100 group-hover:bg-slate-50' }}
                                          {{ $isSelected && !$isToday ? 'bg-slate-800 text-white shadow-sm' : '' }}">
                                    {{ $cellDay }}
                                </a>
                                @if($apptCount > 0)
                                    <span class="inline-flex items-center gap-1 py-0.5 px-2 rounded-lg bg-slate-50 border border-slate-100 text-[9px] font-black text-slate-500 uppercase tracking-tight">
                                        <span class="size-1 rounded-full bg-slate-400"></span>{{ $apptCount }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex-1 space-y-1.5 overflow-y-auto max-h-[95px] pr-0.5 custom-scrollbar">
                                @if($hasAppts)
                                    @foreach($calendar['appointments'][$dateKey] as $appt)
                                        @php
                                            $c = match($appt->status) {
                                                'pending' => 'bg-amber-500 text-white border-amber-600/30 hover:bg-amber-600 hover:border-amber-700',
                                                'scheduled' => 'bg-blue-600 text-white border-blue-700/30 hover:bg-blue-700 hover:border-blue-800',
                                                'confirmed' => 'bg-emerald-600 text-white border-emerald-700/30 hover:bg-emerald-700 hover:border-emerald-800',
                                                'completed' => 'bg-teal-600 text-white border-teal-700/30 hover:bg-teal-700 hover:border-teal-800',
                                                'cancelled' => 'bg-rose-600 text-white border-rose-700/30 hover:bg-rose-700 hover:border-rose-800',
                                                default => 'bg-slate-600 text-white border-slate-700/30 hover:bg-slate-700 hover:border-slate-800',
                                            };
                                        @endphp
                                        <a href="{{ route('agent.appointments.show', $appt) }}"
                                           class="block p-2 rounded-xl border text-[8px] font-extrabold leading-tight transition-all duration-200 hover:-translate-y-0.5 shadow-sm hover:shadow-md whitespace-normal break-words {{ $c }}"
                                           title="{{ $appt->date_time->format('h:i A') }} - {{ optional($appt->client)->name }}: {{ optional($appt->property)->title }}">
                                            <div class="flex items-center justify-between gap-1 mb-1">
                                                <span class="font-black opacity-95 text-[8px]">{{ $appt->date_time->format('h:i A') }}</span>
                                                <span class="size-1 rounded-full bg-white/90 flex-shrink-0"></span>
                                            </div>
                                            <span class="block font-black opacity-95 text-[8px]">{{ optional($appt->client)->name }}</span>
                                            <span class="block opacity-80 font-bold text-[7px] mt-0.5">{{ optional($appt->property)->title }}</span>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="size-full rounded-2xl bg-slate-100/20 border border-dashed border-slate-200/40"></div>
                    @endif
                </div>
            @endfor
        </div>

        {{-- Appointments for selected date --}}
        @if($calDate)
            <div class="mt-8 border-t border-slate-200/60 pt-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <span class="size-2 rounded-full bg-primary-500 animate-pulse"></span>
                        Appointments for {{ \Carbon\Carbon::parse($calDate)->format('M d, Y') }}
                    </h4>
                    <span class="text-xs text-slate-500 font-extrabold bg-white shadow-sm py-1 px-3 rounded-full border border-slate-150">{{ count($selectedDateAppts) }} {{ Str::plural('Meet', count($selectedDateAppts)) }}</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($selectedDateAppts as $appt)
                        <div class="flex items-center justify-between p-5 rounded-2xl bg-white border border-slate-150 shadow-md shadow-slate-100/50 hover:shadow-xl hover:border-slate-300 transition-all duration-300 hover:-translate-y-1 group relative overflow-hidden">
                            <!-- Left gradient bar based on status -->
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ match($appt->status) {
                                'pending' => 'bg-gradient-to-b from-amber-400 to-amber-600',
                                'scheduled' => 'bg-gradient-to-b from-blue-400 to-blue-600',
                                'confirmed' => 'bg-gradient-to-b from-emerald-400 to-emerald-600',
                                'completed' => 'bg-gradient-to-b from-teal-400 to-teal-600',
                                'cancelled' => 'bg-gradient-to-b from-rose-400 to-rose-600',
                                default => 'bg-gradient-to-b from-slate-400 to-slate-600',
                            } }}"></div>

                            <div class="flex items-center gap-4 pl-2">
                                <div class="flex-shrink-0 size-14 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-center justify-center group-hover:bg-primary-50 group-hover:border-primary-100 transition-colors shadow-sm">
                                    <span class="text-xs font-black text-slate-800 group-hover:text-primary-600 leading-none">{{ $appt->date_time->format('h:i') }}</span>
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider group-hover:text-primary-500 mt-1">{{ $appt->date_time->format('A') }}</span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-black text-slate-800 group-hover:text-primary-600 transition-colors">{{ optional($appt->client)->name ?? 'N/A' }}</p>
                                        <span class="text-[9px] text-slate-400 font-bold uppercase bg-slate-50 border border-slate-100 px-1.5 py-0.5 rounded-md">Client</span>
                                    </div>
                                    <p class="text-xs text-slate-400 font-semibold mt-0.5">{{ optional($appt->client)->email ?? '' }}</p>
                                    
                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2.5">
                                        <div class="flex items-center gap-1.5 text-[11px] font-bold text-slate-500">
                                            <svg class="size-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                            <span>{{ optional($appt->property)->title ?? 'Deleted' }}</span>
                                        </div>
                                        @if(optional($appt->property)->city)
                                            <span class="text-[10px] text-slate-400 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded-lg font-bold">{{ $appt->property->city }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col items-end gap-3 pr-1">
                                <span class="py-1 px-3 rounded-full text-[9px] font-black uppercase tracking-wider whitespace-nowrap shadow-sm
                                    {{ match($appt->status) {
                                        'pending' => 'bg-amber-50 text-amber-700 border border-amber-200/60 ring-2 ring-amber-500/5',
                                        'scheduled' => 'bg-blue-50 text-blue-700 border border-blue-200/60 ring-2 ring-blue-500/5',
                                        'confirmed' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/60 ring-2 ring-emerald-500/5',
                                        'completed' => 'bg-teal-50 text-teal-700 border border-teal-200/60 ring-2 ring-teal-500/5',
                                        'cancelled' => 'bg-rose-50 text-rose-700 border border-rose-200/60 ring-2 ring-rose-500/5',
                                        default => 'bg-slate-50 text-slate-700 border border-slate-200/60',
                                    } }}">{{ $appt->status }}</span>
                                <a href="{{ route('agent.appointments.show', $appt) }}"
                                   class="text-xs font-black text-primary-600 hover:text-primary-700 transition-colors whitespace-nowrap flex items-center gap-1 hover:translate-x-0.5 transition-transform duration-200">
                                    <span>Details</span>
                                    <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 py-8 text-center bg-slate-100/40 rounded-2xl border border-dashed border-slate-200/60">
                            <p class="text-sm text-slate-400 font-extrabold">No appointments scheduled for this day.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
