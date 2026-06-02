@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')
@section('page-subtitle', 'Welcome back, ' . Auth::user()->name)

@section('header-actions')
    <a href="{{ route('admin.users.create') }}" class="hidden sm:inline-flex items-center gap-x-2 py-2 px-4 text-sm font-bold rounded-xl bg-primary-500 text-white hover:bg-primary-600 transition-all shadow-md shadow-primary-500/20">
        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 4v16m8-8H4"/></svg>
        Add Member
    </a>
@endsection

@section('content')

{{-- ── STAT CARDS ── --}}
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="flex flex-col bg-white border border-slate-200 shadow-sm rounded-2xl p-5 hover:shadow-md transition-all">
        <div class="flex items-center gap-x-4 mb-3">
            <div class="size-11 flex justify-center items-center rounded-xl flex-shrink-0 bg-primary-50 text-primary-500">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <p class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Total Users</p>
        </div>
        <h3 class="text-3xl font-black text-slate-800">{{ number_format($stats['total_users']) }}</h3>
        <span class="flex items-center gap-x-1 text-emerald-600 font-bold text-sm mt-2">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
            +{{ $stats['new_users_this_month'] }} this month
        </span>
    </div>
    <div class="flex flex-col bg-white border border-slate-200 shadow-sm rounded-2xl p-5 hover:shadow-md transition-all">
        <div class="flex items-center gap-x-4 mb-3">
            <div class="size-11 flex justify-center items-center bg-amber-50 text-amber-600 rounded-xl flex-shrink-0">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <p class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Properties</p>
        </div>
        <h3 class="text-3xl font-black text-slate-800">{{ number_format($stats['total_properties']) }}</h3>
        <span class="flex items-center gap-x-1 text-emerald-600 font-bold text-sm mt-2">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
            +{{ $stats['new_properties_this_month'] }} growth
        </span>
    </div>
    <div class="flex flex-col bg-white border border-slate-200 shadow-sm rounded-2xl p-5 hover:shadow-md transition-all">
        <div class="flex items-center gap-x-4 mb-3">
            <div class="size-11 flex justify-center items-center bg-purple-50 text-purple-600 rounded-xl flex-shrink-0">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            </div>
            <p class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Appointments</p>
        </div>
        <h3 class="text-3xl font-black text-slate-800">{{ number_format($stats['total_appointments']) }}</h3>
        <span class="flex items-center gap-x-1 font-bold text-sm mt-2" style="color:#029fca;">
            {{ $stats['pending_appointments'] }} pending
        </span>
    </div>
    <div class="flex flex-col bg-white border border-slate-200 shadow-sm rounded-2xl p-5 hover:shadow-md transition-all">
        <div class="flex items-center gap-x-4 mb-3">
            <div class="size-11 flex justify-center items-center bg-emerald-50 text-emerald-600 rounded-xl flex-shrink-0">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <p class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Revenue</p>
        </div>
        <h3 class="text-3xl font-black text-slate-800">$0</h3>
        <span class="flex items-center gap-x-1 text-rose-500 font-bold text-sm mt-2">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="22 17 13.5 8.5 8.5 13.5 2 7"/><polyline points="16 17 22 17 22 11"/></svg>
            Awaiting data
        </span>
    </div>
</div>

{{-- ── Two-column section ── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Recent users --}}
    <div class="lg:col-span-2 bg-white border border-slate-200 rounded-3xl shadow-soft overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
            <div>
                <h3 class="font-black text-slate-800">Recent users</h3>
                <p class="text-xs text-slate-400 mt-0.5">Latest accounts to join PropertyHub</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-600 hover:text-primary-700 bg-primary-50 px-3 py-1.5 rounded-full">
                View all
                <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($users as $u)
                <a href="{{ route('admin.users.show', $u) }}" class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition-colors">
                    <div class="size-11 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 text-white flex items-center justify-center font-black text-sm shadow-sm">
                        {{ strtoupper(substr($u->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 truncate">{{ $u->name }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ $u->email }}</p>
                    </div>
                    @php
                        $rmap = [
                            'admin' => 'bg-primary-100 text-primary-700',
                            'agent' => 'bg-emerald-100 text-emerald-700',
                            'buyer' => 'bg-slate-100 text-slate-600',
                        ];
                        $rpill = $rmap[$u->role] ?? 'bg-slate-100 text-slate-600';
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold {{ $rpill }}">
                        <span class="size-1.5 rounded-full bg-current"></span>
                        {{ ucfirst($u->role) }}
                    </span>
                    <span class="text-[10px] font-bold text-slate-400 w-20 text-right hidden sm:block">{{ $u->created_at->diffForHumans() }}</span>
                </a>
            @empty
                <div class="px-6 py-12 text-center text-sm text-slate-500">No users yet.</div>
            @endforelse
        </div>
    </div>

    {{-- Quick links + activity --}}
    <div class="space-y-6">
        <div class="bg-white border border-slate-200 rounded-3xl shadow-soft overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="font-black text-slate-800">Quick actions</h3>
            </div>
            <div class="p-3 space-y-1">
                <a href="{{ route('admin.properties.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-2xl hover:bg-slate-50 group transition-all">
                    <span class="size-10 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center shrink-0">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 group-hover:text-primary-600">Manage properties</p>
                        <p class="text-xs text-slate-400">Approve, reject, edit</p>
                    </div>
                    <svg class="size-4 text-slate-300 group-hover:text-primary-500 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                </a>
                <a href="{{ route('admin.users.create') }}" class="flex items-center gap-3 px-3 py-3 rounded-2xl hover:bg-slate-50 group transition-all">
                    <span class="size-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 group-hover:text-primary-600">Invite a user</p>
                        <p class="text-xs text-slate-400">Create a new account</p>
                    </div>
                    <svg class="size-4 text-slate-300 group-hover:text-primary-500 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                </a>
                <a href="{{ route('admin.logs.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-2xl hover:bg-slate-50 group transition-all">
                    <span class="size-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 group-hover:text-primary-600">Inspect logs</p>
                        <p class="text-xs text-slate-400">Recent application errors</p>
                    </div>
                    <svg class="size-4 text-slate-300 group-hover:text-primary-500 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl shadow-soft p-6">
            <h3 class="font-black text-slate-800">At a glance</h3>
            <p class="text-xs text-slate-400 mt-0.5 mb-4">This week's pulse</p>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between text-xs font-bold mb-1.5">
                        <span class="text-slate-500">New users</span>
                        <span class="text-slate-800">{{ $stats['new_users_this_month'] }}</span>
                    </div>
                    <div class="h-1.5 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full bg-primary-500 rounded-full" style="width: {{ min(100, $stats['new_users_this_month'] * 5) }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs font-bold mb-1.5">
                        <span class="text-slate-500">New listings</span>
                        <span class="text-slate-800">{{ $stats['new_properties_this_month'] }}</span>
                    </div>
                    <div class="h-1.5 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ min(100, $stats['new_properties_this_month'] * 5) }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs font-bold mb-1.5">
                        <span class="text-slate-500">Pending appointments</span>
                        <span class="text-slate-800">{{ $stats['pending_appointments'] }}</span>
                    </div>
                    <div class="h-1.5 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" style="width: {{ min(100, $stats['pending_appointments'] * 5) }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
