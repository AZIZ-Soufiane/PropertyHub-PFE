@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-10">
            <a class="text-3xl font-black tracking-tighter text-primary-500" href="/">PropertyHub</a>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-2">Premium Real Estate</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Sign in</h1>
                <p class="mt-2 text-sm text-gray-600">
                    Don't have an account yet?
                    <a class="text-blue-600 decoration-2 hover:underline font-medium" href="{{ route('register') }}">Sign up here</a>
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="your@email.com">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <a class="text-sm text-blue-600 hover:underline" href="#">Forgot password?</a>
                    </div>
                    <input type="password" id="password" name="password" required
                        class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter your password">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="shrink-0 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="remember" class="ms-2 text-sm text-gray-600">Remember me</label>
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                    Sign in
                </button>
            </form>
        </div>
    </div>
</div>
@endsection