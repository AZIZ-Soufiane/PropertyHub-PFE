@extends('layouts.app')

@section('title', 'Create Account - PropertyHub')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-10">
            <a class="text-3xl font-black tracking-tighter block" href="{{ route('properties.index') }}" style="color:#3b65ad;">PropertyHub</a>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-2">Premium Real Estate</p>
        </div>

        <!-- Form Card -->
        <div class="card">
            <div class="p-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Create Account</h1>
                    <p class="mt-3 text-sm text-gray-600">Join PropertyHub today</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="input-field w-full"
                               placeholder="John Doe">
                        @error('name')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">Email address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="input-field w-full"
                               placeholder="you@example.com">
                        @error('email')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role Field -->
                    <div>
                        <label for="role" class="block text-sm font-semibold text-gray-900 mb-2">I am a</label>
                        <select id="role" name="role" required 
                                class="input-field w-full">
                            <option value="">Select your role</option>
                            <option value="buyer">Buyer</option>
                            <option value="agent">Real Estate Agent</option>
                        </select>
                        @error('role')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-900 mb-2">Password</label>
                        <input type="password" id="password" name="password" required
                               class="input-field w-full"
                               placeholder="••••••••">
                        @error('password')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-900 mb-2">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="input-field w-full"
                               placeholder="••••••••">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full btn-primary py-3 font-semibold text-base">
                        Create Account
                    </button>
                </form>

                <!-- Sign In Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">Already have an account?
                        <a href="{{ route('login') }}" class="text-primary-500 font-semibold hover:text-primary-600">
                            Sign in here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
