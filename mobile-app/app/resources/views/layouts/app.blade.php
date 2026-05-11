<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#3b65ad">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>@yield('title', 'PropertyHub')</title>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased" style="font-family: 'Inter', sans-serif;">
    <!-- Safe Area Container -->
    <div class="flex flex-col min-h-screen">
        <!-- Header/Navbar - Mobile Optimized -->
        <header class="sticky top-0 z-50 bg-white border-b border-slate-200 shadow-sm">
            <nav class="max-w-full px-4 py-3 flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('properties.index') }}" class="flex items-center gap-2 no-underline flex-1">
                    <div class="w-8 h-8 bg-primary-600 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-black text-sm">PH</span>
                    </div>
                    <span class="text-base font-black text-primary-600 tracking-tight hidden sm:inline">PropertyHub</span>
                </a>

                <!-- Desktop Navigation (Hidden on Mobile) -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('properties.index') }}" 
                       class="no-underline text-sm font-medium transition-smooth px-3 py-2 {{ request()->routeIs('properties.index') ? 'text-primary-600 bg-primary-50 rounded-lg' : 'text-slate-600 hover:text-primary-600' }}">
                        Home
                    </a>
                    <a href="{{ route('properties.index') }}" 
                       class="no-underline text-sm font-medium transition-smooth px-3 py-2 {{ request()->routeIs('properties.*') ? 'text-primary-600 bg-primary-50 rounded-lg' : 'text-slate-600 hover:text-primary-600' }}">
                        Properties
                    </a>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-2">
                    <!-- Messages Icon -->
                    <button class="relative p-2 hover:bg-slate-100 rounded-lg transition-smooth">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-primary-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">3</span>
                    </button>

                    <!-- Mobile Hamburger Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden p-2 hover:bg-slate-100 rounded-lg transition-smooth" type="button">
                        <svg id="hamburger-icon" class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </nav>

            <!-- Mobile Menu Drawer -->
            <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 bg-white animate-in fade-in duration-200">
                <div class="px-4 py-4 space-y-2">
                    <a href="{{ route('properties.index') }}" 
                       class="block w-full text-left px-4 py-3 text-base font-semibold rounded-lg transition-colors {{ request()->routeIs('properties.index') && !request()->routeIs('properties.*', false) ? 'text-primary-600 bg-primary-50' : 'text-slate-700 hover:bg-slate-100' }}">
                        Home
                    </a>
                    <a href="{{ route('properties.index') }}" 
                       class="block w-full text-left px-4 py-3 text-base font-semibold rounded-lg transition-colors {{ request()->routeIs('properties.*') ? 'text-primary-600 bg-primary-50' : 'text-slate-700 hover:bg-slate-100' }}">
                        Properties
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 w-full pb-6">
            <!-- Flash Messages -->
            @if($message = session('success'))
                <div class="max-w-full px-4 pt-4">
                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium animate-fade-in">
                        ✓ {{ $message }}
                    </div>
                </div>
            @endif

            @if($message = session('error'))
                <div class="max-w-full px-4 pt-4">
                    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm font-medium animate-fade-in">
                        ✕ {{ $message }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="max-w-full px-4 pt-4">
                    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm">
                        <ul class="space-y-1">
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-slate-900 text-white py-8 border-t border-slate-800">
            <div class="max-w-full px-4">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="font-black text-base text-primary-400">PropertyHub</h3>
                        <p class="text-slate-400 text-xs mt-1">Premium Real Estate</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-slate-400">support@propertyhub.com</p>
                    </div>
                </div>
                <div class="border-t border-slate-800 pt-4 text-center text-slate-400 text-xs">
                    <p>&copy; 2026 PropertyHub. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')

    <!-- Mobile Menu Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            const menuLinks = mobileMenu.querySelectorAll('a');

            if (!menuBtn) return;

            // Toggle menu visibility
            menuBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                mobileMenu.classList.toggle('hidden');
            });

            // Close menu when a link is clicked
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                });
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!menuBtn.contains(event.target) && !mobileMenu.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });

            // Close menu on escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    mobileMenu.classList.add('hidden');
                }
            });
        });
</body>
</html>
</html>
