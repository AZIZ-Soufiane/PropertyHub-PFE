@extends('layouts.admin')

@section('title', 'Appointment Details')
@section('page-title', 'Appointment Details')
@section('page-subtitle', 'Full details for this appointment')

@section('header-actions')
    <a href="{{ route('admin.appointments.index') }}"
       class="inline-flex items-center gap-x-2 py-2.5 px-4 text-sm font-bold rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">
        &larr; Back
    </a>
@endsection

@section('content')
@if(session('success'))
    <div class="mb-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Main info --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
            <h2 class="text-base font-black text-slate-800 mb-5">Appointment Info</h2>
            <dl class="grid grid-cols-2 gap-4">
                <div>
                    <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Date & Time</dt>
                    <dd class="text-sm font-bold text-slate-800">{{ $appointment->date_time->format('M d, Y — h:i A') }}</dd>
                </div>
                <div>
                    <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status</dt>
                    <dd>
                        @php
                            $pill = match($appointment->status) {
                                'pending'   => 'bg-amber-100 text-amber-700',
                                'scheduled' => 'bg-blue-100 text-blue-700',
                                'confirmed' => 'bg-emerald-100 text-emerald-700',
                                'completed' => 'bg-teal-100 text-teal-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                                default     => 'bg-slate-100 text-slate-700',
                            };
                        @endphp
                        <span class="py-1 px-3 inline-flex items-center gap-1 rounded-full text-[10px] font-bold {{ $pill }} uppercase">
                            <span class="size-1.5 rounded-full bg-current"></span>{{ ucfirst($appointment->status) }}
                        </span>
                    </dd>
                </div>
                <div class="col-span-2">
                    <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Property</dt>
                    <dd class="text-sm text-slate-700">{{ optional($appointment->property)->title ?? 'Deleted property' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Side panel: people + actions --}}
    <div class="space-y-4">
        {{-- Client --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Client</p>
            <div class="flex items-center gap-3">
                <div class="size-10 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-black text-sm flex-shrink-0">
                    {{ strtoupper(substr(optional($appointment->client)->name ?? '?', 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">{{ optional($appointment->client)->name ?? 'N/A' }}</p>
                    <p class="text-xs text-slate-400">{{ optional($appointment->client)->email }}</p>
                </div>
            </div>
        </div>

        {{-- Agent --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Assigned Agent</p>
            <div class="flex items-center gap-3">
                <div class="size-10 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-black text-sm flex-shrink-0">
                    {{ strtoupper(substr(optional($appointment->agent)->name ?? '?', 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">{{ optional($appointment->agent)->name ?? 'N/A' }}</p>
                    <p class="text-xs text-slate-400">{{ optional($appointment->agent)->email }}</p>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-2">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Actions</p>
            @if(in_array($appointment->status, ['pending', 'scheduled']))
                <form action="{{ route('admin.appointments.confirm', $appointment) }}" method="POST">
                    @csrf
                    <button class="w-full py-2 px-4 bg-emerald-100 text-emerald-700 rounded-xl text-sm font-bold hover:bg-emerald-200 transition-all">
                        Confirm Appointment
                    </button>
                </form>
            @endif
            @if($appointment->status === 'confirmed')
                <form action="{{ route('admin.appointments.complete', $appointment) }}" method="POST">
                    @csrf
                    <button class="w-full py-2 px-4 bg-teal-100 text-teal-700 rounded-xl text-sm font-bold hover:bg-teal-200 transition-all">
                        Mark as Completed
                    </button>
                </form>
            @endif
            @if($appointment->status !== 'cancelled')
                <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST">
                    @csrf
                    <button type="button" @click="$store.confirm.ask('Cancel this appointment?', $el.closest('form'))"
                            class="w-full py-2 px-4 bg-red-100 text-red-700 rounded-xl text-sm font-bold hover:bg-red-200 transition-all">
                        Cancel Appointment
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
