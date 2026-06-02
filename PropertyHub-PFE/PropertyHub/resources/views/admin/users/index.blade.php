@extends('layouts.admin')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Users & Roles</h1>
        <p class="text-sm text-gray-500 mt-1">Manage system users and permissions</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl bg-blue-600 text-white hover:bg-blue-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path d="M12 4v16m8-8H4" />
        </svg>
        Add User
    </a>
</div>

<div class="bg-white border border-gray-200 rounded-3xl overflow-hidden">
    <form method="GET" action="{{ route('admin.users.index') }}" class="px-6 py-4 border-b border-gray-100 flex flex-col md:flex-row gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
            class="flex-1 py-2.5 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500">
        <select name="role" class="py-2.5 px-4 border border-gray-200 rounded-xl text-sm">
            <option value="">All roles</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="agent" {{ request('role') === 'agent' ? 'selected' : '' }}>Agent</option>
            <option value="buyer" {{ request('role') === 'buyer' ? 'selected' : '' }}>Buyer</option>
        </select>
        <button type="submit" class="py-2.5 px-5 bg-gray-800 text-white text-sm font-bold rounded-xl hover:bg-gray-900">Filter</button>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50/60">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">User</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Email</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Role</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Joined</th>
                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $u)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <p class="text-sm font-bold text-gray-800">{{ $u->name }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $u->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="py-1 px-3 rounded-full text-[10px] font-bold
                                {{ $u->role === 'admin' ? 'bg-purple-100 text-purple-700' : ($u->role === 'agent' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700') }}">
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $u->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('admin.users.show', $u) }}" class="text-xs text-blue-600 hover:underline mr-3">View</a>
                            <a href="{{ route('admin.users.edit', $u) }}" class="text-xs text-amber-600 hover:underline mr-3">Edit</a>
                            @if($u->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this user?')" class="text-xs text-rose-600 hover:underline">Delete</button>
                                </form>
                            @endif
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

    @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
