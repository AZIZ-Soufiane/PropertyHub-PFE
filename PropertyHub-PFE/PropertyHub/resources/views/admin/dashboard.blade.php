@extends('layouts.admin')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
    <p class="text-sm text-gray-500 mt-1">Welcome back, {{ Auth::user()->name }}</p>
</div>

<!-- Stats Cards -->
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5 hover:shadow-md transition-all">
        <div class="flex items-center gap-4 mb-3">
            <div class="w-11 h-11 flex justify-center items-center rounded-xl bg-blue-50 text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
            </div>
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Total Users</p>
        </div>
        <h3 class="text-3xl font-black text-gray-800">{{ $stats['total_users'] ?? 0 }}</h3>
        <span class="flex items-center gap-x-1 text-emerald-600 font-bold text-sm mt-2">
            +{{ $stats['new_users_this_month'] ?? 0 }} this month
        </span>
    </div>

    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5 hover:shadow-md transition-all">
        <div class="flex items-center gap-4 mb-3">
            <div class="w-11 h-11 flex justify-center items-center rounded-xl bg-amber-50 text-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
            </div>
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Properties</p>
        </div>
        <h3 class="text-3xl font-black text-gray-800">{{ $stats['total_properties'] ?? 0 }}</h3>
        <span class="flex items-center gap-x-1 text-emerald-600 font-bold text-sm mt-2">
            +{{ $stats['new_properties_this_month'] ?? 0 }} this month
        </span>
    </div>

    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5 hover:shadow-md transition-all">
        <div class="flex items-center gap-4 mb-3">
            <div class="w-11 h-11 flex justify-center items-center rounded-xl bg-purple-50 text-purple-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                    <line x1="16" x2="16" y1="2" y2="6" />
                    <line x1="8" x2="8" y1="2" y2="6" />
                    <line x1="3" x2="21" y1="10" y2="10" />
                </svg>
            </div>
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Appointments</p>
        </div>
        <h3 class="text-3xl font-black text-gray-800">{{ $stats['total_appointments'] ?? 0 }}</h3>
        <span class="text-gray-500 font-bold text-sm mt-2">
            {{ $stats['pending_appointments'] ?? 0 }} pending
        </span>
    </div>

    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5 hover:shadow-md transition-all">
        <div class="flex items-center gap-4 mb-3">
            <div class="w-11 h-11 flex justify-center items-center rounded-xl bg-emerald-50 text-emerald-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
            </div>
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Revenue</p>
        </div>
        <h3 class="text-3xl font-black text-gray-800">${{ number_format($stats['total_revenue'] ?? 0) }}</h3>
        <span class="text-gray-500 font-bold text-sm mt-2">Total generated</span>
    </div>
</div>

<!-- Users Management Table -->
<div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-3xl overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <h2 class="text-xl font-bold text-gray-800">User Management</h2>
        <a href="{{ route('admin.users.create') }}" 
           class="py-2.5 px-5 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path d="M12 4v16m8-8H4" />
            </svg>
            Add Member
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50/60">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Profile</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Role</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Joined</th>
                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users ?? [] as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <img class="w-10 h-10 rounded-full" src="{{ $user->avatar ?? 'https://via.placeholder.com/40' }}" alt="">
                                <div>
                                    <p class="text-sm font-bold text-gray-800">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-400 font-medium">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wide
                                {{ $user->role === 'admin' ? 'bg-blue-100 text-blue-700' : ($user->role === 'agent' ? 'bg-primary-100 text-primary-700' : 'bg-gray-100 text-gray-700') }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="py-1 px-3 inline-flex items-center gap-1 rounded-full text-[10px] font-bold
                                {{ $user->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $user->status === 'active' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-400 font-semibold">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="w-8 h-8 inline-flex justify-center items-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="w-8 h-8 inline-flex justify-center items-center text-gray-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </a>
                                @if($user->id !== Auth::id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                            class="w-8 h-8 inline-flex justify-center items-center text-gray-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($users) && $users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-400 font-semibold">Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users</p>
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection