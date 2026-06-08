@extends('layouts.admin')

@section('title', 'Appointments')
@section('page-title', 'Appointments')
@section('page-subtitle', 'All appointment requests across managed properties')

@section('content')

@if(session('success'))
    <div class="mb-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
        {{ session('success') }}
    </div>
@endif

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
    @php
        $statItems = [
            ['label' => 'Total',     'value' => $stats['total'],     'color' => 'slate'],
            ['label' => 'Pending',   'value' => $stats['pending'],   'color' => 'amber'],
            ['label' => 'Confirmed', 'value' => $stats['confirmed'], 'color' => 'emerald'],
            ['label' => 'Completed', 'value' => $stats['completed'], 'color' => 'teal'],
            ['label' => 'Cancelled', 'value' => $stats['cancelled'], 'color' => 'red'],
            ['label' => 'Today',     'value' => $stats['today'],     'color' => 'primary'],
        ];
    @endphp
    @foreach($statItems as $s)
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $s['label'] }}</p>
            <p class="mt-1 text-3xl font-black text-slate-800">{{ $s['value'] }}</p>
        </div>
    @endforeach
</div>

{{-- Table --}}
<div class="bg-white border border-slate-200 shadow-sm rounded-3xl overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.appointments.index') }}"
               class="py-1.5 px-4 rounded-xl text-xs font-bold transition-all {{ !$status ? 'bg-primary-500 text-white shadow' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                All
            </a>
            @foreach(['pending','scheduled','confirmed','completed','cancelled'] as $s)
                <a href="{{ route('admin.appointments.index', ['status' => $s]) }}"
                   class="py-1.5 px-4 rounded-xl text-xs font-bold capitalize transition-all {{ $status === $s ? 'bg-primary-500 text-white shadow' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    {{ $s }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50/60">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Client</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Property</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Agent</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Date & Time</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($appointments as $appt)
                    @php
                        $st = $appt->status;
                        $pill = match($st) {
                            'pending'   => 'bg-amber-100 text-amber-700',
                            'scheduled' => 'bg-blue-100 text-blue-700',
                            'confirmed' => 'bg-emerald-100 text-emerald-700',
                            'completed' => 'bg-teal-100 text-teal-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                            default     => 'bg-slate-100 text-slate-700',
                        };
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-bold text-slate-800">{{ optional($appt->client)->name ?? 'N/A' }}</p>
                            <p class="text-xs text-slate-400">{{ optional($appt->client)->email }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            {{ optional($appt->property)->title ?? 'Deleted property' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            {{ optional($appt->agent)->name ?? '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                            {{ $appt->date_time->format('M d, Y') }}<br>
                            <span class="text-xs font-semibold">{{ $appt->date_time->format('h:i A') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="py-1 px-3 inline-flex items-center gap-1 rounded-full text-[10px] font-bold {{ $pill }} uppercase">
                                <span class="size-1.5 rounded-full bg-current"></span>{{ ucfirst($st) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.appointments.show', $appt) }}"
                                   class="py-1.5 px-3 bg-white border border-slate-200 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-50">
                                    View
                                </a>
                                @if(in_array($st, ['pending', 'scheduled']))
                                    <form action="{{ route('admin.appointments.confirm', $appt) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="py-1.5 px-3 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold hover:bg-emerald-200">Confirm</button>
                                    </form>
                                @endif
                                @if($st === 'confirmed')
                                    <form action="{{ route('admin.appointments.complete', $appt) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="py-1.5 px-3 bg-teal-100 text-teal-700 rounded-lg text-xs font-bold hover:bg-teal-200">Complete</button>
                                    </form>
                                @endif
                                @if($st !== 'cancelled')
                                    <form action="{{ route('admin.appointments.cancel', $appt) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Cancel this appointment?')">
                                        @csrf
                                        <button class="py-1.5 px-3 bg-red-100 text-red-700 rounded-lg text-xs font-bold hover:bg-red-200">Cancel</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">No appointments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($appointments->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $appointments->appends(request()->query())->links() }}
        </div>
    @endif
</div>

{{-- Calendar --}}
@php
    $calQuery = array_filter(request()->query(), fn($k) => !in_array($k, ['cal_date']), ARRAY_FILTER_USE_KEY);
@endphp
<div class="mt-8 bg-white border border-slate-200 shadow-sm rounded-3xl overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
        <h3 class="text-sm font-black text-slate-700 uppercase tracking-widest">Calendar</h3>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.appointments.index', array_merge($calQuery, ['year' => $calendar['prevMonth']->year, 'month' => $calendar['prevMonth']->month])) }}"
               class="size-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 transition-colors">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <span class="text-sm font-bold text-slate-700 min-w-[140px] text-center">{{ $calendar['monthName'] }} {{ $calendar['year'] }}</span>
            <a href="{{ route('admin.appointments.index', array_merge($calQuery, ['year' => $calendar['nextMonth']->year, 'month' => $calendar['nextMonth']->month])) }}"
               class="size-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 transition-colors">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-7 mb-2">
            @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $d)
                <div class="text-center text-[10px] font-black text-slate-400 uppercase tracking-widest py-1">{{ $d }}</div>
            @endforeach
        </div>
        <div class="grid grid-cols-7">
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
                <div class="aspect-square p-1">
                    @if($isValid)
                        <a href="{{ route('admin.appointments.index', array_merge($calQuery, ['year' => $calendar['year'], 'month' => $calendar['month'], 'cal_date' => $dateKey])) }}"
                           class="size-full rounded-xl flex flex-col items-center justify-center text-sm transition-all
                                  {{ $isSelected ? 'ring-2 ring-primary-500 bg-primary-100 text-primary-800 font-bold' : '' }}
                                  {{ !$isSelected && $isToday ? 'ring-2 ring-primary-300' : '' }}
                                  {{ $hasAppts ? 'bg-primary-50 text-primary-700 font-bold hover:bg-primary-100' : 'text-slate-500 hover:bg-slate-50' }}">
                            <span>{{ $cellDay }}</span>
                            @if($apptCount > 0)
                                <span class="text-[9px] font-bold text-primary-500 -mt-0.5">{{ $apptCount }}</span>
                            @endif
                        </a>
                    @else
                        <div class="size-full"></div>
                    @endif
                </div>
            @endfor
        </div>

        {{-- Appointments for selected date --}}
        @if($calDate)
            <div class="mt-6 border-t border-slate-100 pt-4">
                <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest mb-3">Appointments for {{ $calDate }}</h4>
                @forelse($selectedDateAppts as $appt)
                    <div class="flex items-center justify-between py-3 px-4 rounded-xl hover:bg-slate-50 transition-colors border border-slate-100 mb-2">
                        <div class="flex items-start gap-4">
                            <div class="text-center min-w-[60px]">
                                <p class="text-sm font-black text-slate-700">{{ $appt->date_time->format('h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ optional($appt->client)->name ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-400">{{ optional($appt->client)->email ?? '' }}</p>
                                <p class="text-xs text-slate-500 mt-1">
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
                                    default => 'bg-slate-100 text-slate-700',
                                } }}">{{ $appt->status }}</span>
                            <a href="{{ route('admin.appointments.show', $appt) }}"
                               class="text-xs font-bold text-primary-500 hover:text-primary-600 transition-colors whitespace-nowrap">View Details</a>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 py-2">No appointments this day.</p>
                @endforelse
            </div>
        @endif
    </div>
</div>
@endsection
