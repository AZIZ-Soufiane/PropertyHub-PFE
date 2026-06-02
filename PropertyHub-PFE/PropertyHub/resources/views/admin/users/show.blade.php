@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">User Details</h1>
    <p class="text-sm text-gray-500 mt-1">View and manage this user</p>
</div>

<div class="bg-white border border-gray-200 rounded-3xl p-8 space-y-4">
    <div class="flex items-center gap-4 pb-4 border-b border-gray-100">
        <div class="w-16 h-16 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-2xl">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
            <p class="text-sm text-gray-500">{{ $user->email }}</p>
        </div>
    </div>

    <dl class="grid md:grid-cols-2 gap-4">
        <div>
            <dt class="text-xs font-bold text-gray-400 uppercase tracking-widest">Role</dt>
            <dd class="mt-1 text-sm text-gray-800 font-semibold">{{ ucfirst($user->role) }}</dd>
        </div>
        <div>
            <dt class="text-xs font-bold text-gray-400 uppercase tracking-widest">Joined</dt>
            <dd class="mt-1 text-sm text-gray-800 font-semibold">{{ $user->created_at->format('M d, Y') }}</dd>
        </div>
        @if($user->license_number)
            <div>
                <dt class="text-xs font-bold text-gray-400 uppercase tracking-widest">License #</dt>
                <dd class="mt-1 text-sm text-gray-800 font-semibold">{{ $user->license_number }}</dd>
            </div>
        @endif
    </dl>

    <div class="pt-4 flex gap-3">
        <a href="{{ route('admin.users.edit', $user) }}" class="py-2.5 px-5 bg-amber-500 text-white text-sm font-bold rounded-xl hover:bg-amber-600">Edit</a>
        <a href="{{ route('admin.users.index') }}" class="py-2.5 px-5 bg-gray-100 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-200">Back</a>
    </div>
</div>
@endsection
