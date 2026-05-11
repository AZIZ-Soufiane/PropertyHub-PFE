@extends('layouts.app')

@section('title', 'Sign In - PropertyHub')

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
                    <h1 class="text-3xl font-bold text-gray-900">Sign in</h1>
                    <p class="mt-3 text-sm text-gray-600">
                        Don't have an account yet?
                        <a class="text-primary-500 decoration-2 hover:underline font-semibold" href="{{ route('register') }}">
                            Sign up here
                        </a>
                    </p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
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

                    <!-- Password Field -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-sm font-semibold text-gray-900">Password</label>
                            <a href="#" class="text-sm text-primary-500 hover:text-primary-600 font-semibold">Forgot?</a>
                        </div>
                        <input type="password" id="password" name="password" required
                               class="input-field w-full"
                               placeholder="••••••••">
                        @error('password')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="rounded">
                        <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full btn-primary py-3 font-semibold text-base">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
