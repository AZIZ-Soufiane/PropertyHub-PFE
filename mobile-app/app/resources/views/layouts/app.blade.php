<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#3b65ad">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>@yield('title', 'PropertyHub')</title>
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased" style="font-family: 'Inter', sans-serif;">
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        <header class="sticky top-0 z-50 w-full bg-white/80 backdrop-blur-md border-b border-gray-200" x-data="{ mobileOpen: false }">
            <nav class="max-w-7xl mx-auto px-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-3">
                    <a href="{{ route('home') }}" class="text-xl font-black tracking-tighter text-primary-500 no-underline">PropertyHub</a>
                    <!-- Mobile menu button -->
                    <button @click="mobileOpen = !mobileOpen" class="sm:hidden p-2 hover:bg-gray-100 rounded-lg transition-colors" type="button">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                <div class="hidden sm:flex items-center gap-x-8 py-3">
                    <a href="{{ route('home') }}" class="font-semibold text-sm {{ request()->routeIs('home') || request()->routeIs('welcome') ? 'text-blue-600' : 'text-gray-600 hover:text-blue-600' }} transition-colors">Home</a>
                    <a href="{{ route('properties.index') }}" class="font-semibold text-sm {{ request()->routeIs('properties.*') ? 'text-blue-600' : 'text-gray-600 hover:text-blue-600' }} transition-colors">Properties</a>
                    <a href="{{ route('compare') }}" class="font-semibold text-sm {{ request()->routeIs('compare') ? 'text-blue-600' : 'text-gray-600 hover:text-blue-600' }} transition-colors">Compare</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="py-2 px-4 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 transition-all">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="py-2 px-4 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-black transition-all">Sign In</a>
                    @endauth
                </div>
            </nav>

            <!-- Mobile Menu -->
            <div x-show="mobileOpen" @click.away="mobileOpen = false" x-cloak class="sm:hidden border-t border-gray-100 bg-white">
                <div class="px-4 py-4 space-y-2">
                    <a href="{{ route('home') }}" @click="mobileOpen = false" class="block w-full text-left px-4 py-3 text-base font-semibold rounded-lg {{ request()->routeIs('home') || request()->routeIs('welcome') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:bg-gray-100' }}">Home</a>
                    <a href="{{ route('properties.index') }}" @click="mobileOpen = false" class="block w-full text-left px-4 py-3 text-base font-semibold rounded-lg {{ request()->routeIs('properties.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:bg-gray-100' }}">Properties</a>
                    <a href="{{ route('compare') }}" @click="mobileOpen = false" class="block w-full text-left px-4 py-3 text-base font-semibold rounded-lg {{ request()->routeIs('compare') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:bg-gray-100' }}">Compare</a>
                    @auth
                        <a href="{{ route('dashboard') }}" @click="mobileOpen = false" class="block w-full text-left px-4 py-3 text-base font-semibold rounded-lg text-gray-700 hover:bg-gray-100">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" @click="mobileOpen = false" class="block w-full text-left px-4 py-3 text-base font-semibold rounded-lg bg-gray-900 text-white">Sign In</a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 w-full">
            @if($message = session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium">✓ {{ $message }}</div>
                </div>
            @endif
            @if($message = session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm font-medium">✕ {{ $message }}</div>
                </div>
            @endif
            @if($errors->any())
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm">
                        <ul class="space-y-1">@foreach($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>
                    </div>
                </div>
            @endif
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-slate-950 py-12 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <a class="text-xl font-black text-white mb-3 block tracking-tighter" href="/">Property<span class="text-blue-500">Hub.</span></a>
                        <p class="text-gray-500 font-medium text-xs">Elevating the real estate experience through intelligent management and stunning presentation.</p>
                    </div>
                    <div>
                        <h4 class="text-gray-400 font-black mb-3 text-[10px] uppercase tracking-widest">Quick Access</h4>
                        <ul class="space-y-2 text-white font-bold text-xs">
                            <li><a class="hover:text-blue-500 transition-colors" href="{{ route('properties.index') }}">Listings</a></li>
                            <li><a class="hover:text-blue-500 transition-colors" href="{{ route('compare') }}">Comparison</a></li>
                            <li><a class="hover:text-blue-500 transition-colors" href="{{ route('login') }}">Authentication</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-white/5 mt-8 pt-6 flex justify-between text-[10px] font-black text-gray-600 uppercase tracking-widest">
                    <span>&copy; {{ date('Y') }} PropertyHub</span>
                    <span>Crafted by Solicode</span>
                </div>
            </div>
        </footer>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    @stack('scripts')
</body>
</html>