@extends('layouts.admin')

@section('title', 'System Activity Logs')
@section('page-title', 'Activity Logs')
@section('page-subtitle', 'Real-time record of application events (signups, logins, listing updates)')

@section('header-actions')
    <a href="{{ route('admin.logs.index') }}" class="inline-flex items-center gap-x-2 py-2.5 px-4 text-sm font-bold rounded-xl bg-primary-600 text-white hover:bg-primary-700 shadow-md shadow-primary-500/20 transition-all">
        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182"/></svg>
        Refresh
    </a>
@endsection

@section('content')

<div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
    @foreach($levelStats as $level => $count)
        @php
            $tone = match($level) {
                'signup'          => ['bg' => 'bg-emerald-50',   'text' => 'text-emerald-700','dot' => 'bg-emerald-500'],
                'login'           => ['bg' => 'bg-primary-50',   'text' => 'text-primary-700','dot' => 'bg-primary-500'],
                'logout'          => ['bg' => 'bg-slate-50',     'text' => 'text-slate-600',  'dot' => 'bg-slate-400'],
                'create_property' => ['bg' => 'bg-blue-50',      'text' => 'text-blue-700',   'dot' => 'bg-blue-500'],
                'approve_property'=> ['bg' => 'bg-emerald-50',   'text' => 'text-emerald-700','dot' => 'bg-emerald-500'],
                'reject_property' => ['bg' => 'bg-rose-50',      'text' => 'text-rose-700',   'dot' => 'bg-rose-500'],
                'create_user'     => ['bg' => 'bg-indigo-50',    'text' => 'text-indigo-700', 'dot' => 'bg-indigo-500'],
                'delete_user'     => ['bg' => 'bg-rose-50',      'text' => 'text-rose-700',   'dot' => 'bg-rose-500'],
                default           => ['bg' => 'bg-slate-50',     'text' => 'text-slate-600',  'dot' => 'bg-slate-400'],
            };
        @endphp
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-soft">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ str_replace('_', ' ', $level) }}</p>
            <p class="mt-2 text-3xl font-black text-slate-800">{{ $count }}</p>
            <span class="mt-2 inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold {{ $tone['bg'] }} {{ $tone['text'] }}">
                <span class="size-1.5 rounded-full {{ $tone['dot'] }}"></span>
                {{ str_replace('_', ' ', $level) }}
            </span>
        </div>
    @endforeach
</div>

<div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-2xl overflow-hidden mt-8">
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800">
        <div class="flex items-center gap-3">
            <span class="flex gap-1.5">
                <span class="size-2.5 rounded-full bg-rose-500"></span>
                <span class="size-2.5 rounded-full bg-amber-500"></span>
                <span class="size-2.5 rounded-full bg-emerald-500"></span>
            </span>
            <h3 class="text-sm font-bold text-slate-300">app_activity.log</h3>
        </div>
        <span class="text-[10px] text-slate-500 font-mono">Last {{ count($logs) }} entries · newest first</span>
    </div>

    @if(count($logs) === 0)
        <div class="p-12 text-center">
            <svg class="size-10 text-slate-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/></svg>
            <p class="text-sm text-slate-400">No activity logged yet.</p>
            <p class="text-xs text-slate-500 mt-1">Activities will appear here once logged.</p>
        </div>
    @else
        <ul class="divide-y divide-slate-800 max-h-[640px] overflow-y-auto">
            @foreach($logs as $log)
                @php
                    $tone = match($log['level']) {
                        'SIGNUP'           => ['bg' => 'bg-emerald-500/15', 'text' => 'text-emerald-400', 'dot' => 'bg-emerald-500'],
                        'LOGIN'            => ['bg' => 'bg-primary-500/15', 'text' => 'text-primary-400', 'dot' => 'bg-primary-500'],
                        'LOGOUT'           => ['bg' => 'bg-slate-500/15',   'text' => 'text-slate-400',   'dot' => 'bg-slate-500'],
                        'CREATE_PROPERTY'  => ['bg' => 'bg-blue-500/15',    'text' => 'text-blue-400',    'dot' => 'bg-blue-500'],
                        'APPROVE_PROPERTY' => ['bg' => 'bg-emerald-500/15', 'text' => 'text-emerald-400', 'dot' => 'bg-emerald-500'],
                        'REJECT_PROPERTY'  => ['bg' => 'bg-rose-500/15',    'text' => 'text-rose-400',    'dot' => 'bg-rose-500'],
                        'CREATE_USER'      => ['bg' => 'bg-indigo-500/15',  'text' => 'text-indigo-400',  'dot' => 'bg-indigo-500'],
                        'DELETE_USER'      => ['bg' => 'bg-rose-500/15',    'text' => 'text-rose-400',    'dot' => 'bg-rose-500'],
                        default            => ['bg' => 'bg-slate-500/15',   'text' => 'text-slate-400',   'dot' => 'bg-slate-500'],
                    };
                @endphp
                <li class="px-6 py-4 hover:bg-slate-800/40 transition-colors">
                    <div class="flex flex-wrap items-center gap-3 mb-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black {{ $tone['bg'] }} {{ $tone['text'] }}">
                            <span class="size-1.5 rounded-full {{ $tone['dot'] }}"></span>
                            {{ $log['level'] }}
                        </span>
                        <span class="text-xs text-slate-500 font-mono">{{ $log['date'] }}</span>
                        <span class="text-[10px] text-slate-600 font-mono uppercase tracking-widest">[{{ $log['env'] }}]</span>
                    </div>
                    <pre class="text-xs text-slate-300 font-mono whitespace-pre-wrap break-words leading-relaxed">{{ $log['message'] }}</pre>
                </li>
            @endforeach
        </ul>
    @endif
</div>

@endsection
