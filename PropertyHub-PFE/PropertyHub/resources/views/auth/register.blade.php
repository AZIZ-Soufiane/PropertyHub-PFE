@extends('layouts.frontend')

@section('title', 'Create Account — PropertyHub')

@section('content')
    <main class="w-full max-w-md mx-auto p-4 sm:p-6 md:p-8 flex flex-col min-h-screen justify-center">
        <div class="text-center mb-10">
            <a class="text-3xl font-black tracking-tighter text-primary-500" href="{{ route('home') }}">PropertyHub</a>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2">Premium Real Estate</p>
        </div>
        <div class="mt-6 sm:mt-8 bg-white border border-gray-200 rounded-xl md:rounded-2xl shadow-sm">
            <div class="p-4 sm:p-6 md:p-8">
                <div class="text-center">
                    <h1 class="block text-xl sm:text-2xl md:text-3xl font-bold text-gray-800">Create Account</h1>
                    <p class="mt-2 sm:mt-3 text-xs sm:text-sm text-gray-600">
                        Already have an account?
                        <a class="text-primary-500 decoration-2 hover:underline font-medium" href="{{ route('login') }}">Sign in</a>
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mt-5 p-3 bg-rose-50 border border-rose-200 rounded-lg text-xs sm:text-sm text-rose-600 font-medium">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="mt-5 sm:mt-6 md:mt-8">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="grid gap-y-4 sm:gap-y-5 md:gap-y-6">
                            <div>
                                <label for="name" class="block text-xs sm:text-sm mb-2 sm:mb-3 text-gray-900">Full name</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="py-2 sm:py-3 px-3 sm:px-4 block w-full border border-gray-200 rounded-lg text-xs sm:text-sm focus:border-primary-500 focus:ring-primary-500 outline-none" placeholder="John Doe">
                            </div>

                            <div>
                                <label for="email" class="block text-xs sm:text-sm mb-2 sm:mb-3 text-gray-900">Email address</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="py-2 sm:py-3 px-3 sm:px-4 block w-full border border-gray-200 rounded-lg text-xs sm:text-sm focus:border-primary-500 focus:ring-primary-500 outline-none" placeholder="your@email.com">
                            </div>

                            <div>
                                <label for="password" class="block text-xs sm:text-sm mb-2 sm:mb-3 text-gray-900">Password</label>
                                <input type="password" id="password" name="password" required minlength="8" class="py-2 sm:py-3 px-3 sm:px-4 block w-full border border-gray-200 rounded-lg text-xs sm:text-sm focus:border-primary-500 focus:ring-primary-500 outline-none" placeholder="Min 8 characters">
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-xs sm:text-sm mb-2 sm:mb-3 text-gray-900">Confirm password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required class="py-2 sm:py-3 px-3 sm:px-4 block w-full border border-gray-200 rounded-lg text-xs sm:text-sm focus:border-primary-500 focus:ring-primary-500 outline-none" placeholder="Repeat password">
                            </div>

                            <div class="flex items-center">
                                <div class="flex">
                                    <input id="terms" name="terms" type="checkbox" required class="shrink-0 mt-0.5 border-gray-200 rounded text-primary-500 focus:ring-primary-500">
                                </div>
                                <div class="ms-3">
                                    <label for="terms" class="text-xs sm:text-sm text-gray-900">I agree to the <a class="text-primary-500 hover:underline" href="#">Terms</a> &amp; <a class="text-primary-500 hover:underline" href="#">Privacy</a></label>
                                </div>
                            </div>

                            <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-primary-500 text-white hover:bg-primary-600 disabled:opacity-50 disabled:pointer-events-none transition-all">
                                Create Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
