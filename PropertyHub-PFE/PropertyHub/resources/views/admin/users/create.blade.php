@extends('layouts.admin')

@section('content')
@php
    $isEdit = isset($user) && $user->exists;
    $action = $isEdit ? route('admin.users.update', $user) : route('admin.users.store');
    $title = $isEdit ? 'Edit User' : 'Create User';
    $submit = $isEdit ? 'Update User' : 'Create User';
@endphp
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">{{ $title }}</h1>
    <p class="text-sm text-gray-500 mt-1">Manage system users and roles</p>
</div>

<div class="bg-white border border-gray-200 rounded-3xl p-8">
    <form action="{{ $action }}" method="POST" class="space-y-6">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Full Name *</label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
                    class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500"
                    placeholder="e.g. John Doe">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                    class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500"
                    placeholder="john@example.com">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Password {{ $isEdit ? '(leave blank to keep)' : '*' }}</label>
                <input type="password" name="password" {{ $isEdit ? '' : 'required' }} minlength="8"
                    class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" {{ $isEdit ? '' : 'required' }}
                    class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Role *</label>
                <select name="role" required class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm">
                    @php $cur = old('role', $user->role ?? 'buyer'); @endphp
                    <option value="buyer" {{ $cur === 'buyer' ? 'selected' : '' }}>Buyer</option>
                    <option value="agent" {{ $cur === 'agent' ? 'selected' : '' }}>Agent</option>
                    <option value="admin" {{ $cur === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.users.index') }}" class="py-3 px-6 border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="py-3 px-6 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700">
                {{ $submit }}
            </button>
        </div>
    </form>
</div>
@endsection