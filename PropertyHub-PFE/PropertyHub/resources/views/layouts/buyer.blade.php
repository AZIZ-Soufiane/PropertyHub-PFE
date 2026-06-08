<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'My Dashboard — PropertyHub' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/preline/dist/preline.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak]{display:none!important}</style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    @php
    $user = Auth::user();
    $unreadMessages = $user->receivedMessages()->whereNull('read_at')->count();
    @endphp

    <div x-data="{ sidebarOpen: false }">

        {{-- Mobile backdrop --}}
        <div x-show="sidebarOpen" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false" x-cloak></div>

        {{-- Sidebar --}}
        <aside id="buyer-sidebar"
            class="fixed top-0 start-0 bottom-0 z-[60] w-full sm:w-64 bg-white border-e border-gray-200 pt-6 sm:pt-7 pb-0 overflow-y-auto -translate-x-full lg:translate-x-0 transition-all duration-300 flex flex-col"
            :class="sidebarOpen && 'translate-x-0'">
            <div class="px-4 sm:px-6 mb-6 sm:mb-8">
                <a class="text-xl sm:text-2xl font-black tracking-tighter" href="{{ route('home') }}" aria-label="PropertyHub" style="color:#3b65ad;">PropertyHub</a>
                <p class="text-[8px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1 sm:mt-2">My Account</p>
            </div>
            <nav class="px-4 sm:px-6 flex-1">
                <ul class="space-y-1.5">
                    <li>
                        <a class="flex items-center gap-x-3 sm:gap-x-3.5 py-2 px-3 text-xs sm:text-sm rounded-lg sm:rounded-xl transition-all {{ request()->routeIs('buyer.dashboard') ? 'bg-primary-50 text-primary-500 font-semibold' : 'text-gray-700 font-medium hover:bg-gray-100' }}"
                           href="{{ route('buyer.dashboard') }}" @click="sidebarOpen = false">
                            <svg class="size-3 sm:size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><line x1="3" x2="21" y1="9" y2="9"/><line x1="9" x2="9" y1="21" y2="9"/></svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a class="w-full flex items-center gap-x-3 sm:gap-x-3.5 py-2 sm:py-2.5 px-3 text-xs sm:text-sm rounded-lg sm:rounded-xl transition-all {{ request()->routeIs('buyer.appointments.*') ? 'bg-primary-50 text-primary-500 font-semibold' : 'text-gray-700 font-medium hover:bg-gray-100' }}"
                           href="{{ route('buyer.appointments.index') }}" @click="sidebarOpen = false">
                            <svg class="size-3 sm:size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                            My Appointments
                        </a>
                    </li>
                    <li>
                        <a class="w-full flex items-center gap-x-3 sm:gap-x-3.5 py-2 sm:py-2.5 px-3 text-xs sm:text-sm rounded-lg sm:rounded-xl transition-all {{ request()->routeIs('buyer.favorites.*') ? 'bg-primary-50 text-primary-500 font-semibold' : 'text-gray-700 font-medium hover:bg-gray-100' }}"
                           href="{{ route('buyer.favorites.index') }}" @click="sidebarOpen = false">
                            <svg class="size-3 sm:size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                            My Favorites
                        </a>
                    </li>
                    <li>
                        <a class="w-full flex items-center gap-x-3 sm:gap-x-3.5 py-2 sm:py-2.5 px-3 text-xs sm:text-sm rounded-lg sm:rounded-xl transition-all {{ request()->routeIs('buyer.messages.*') ? 'bg-primary-50 text-primary-500 font-semibold' : 'text-gray-700 font-medium hover:bg-gray-100' }}"
                           href="{{ route('buyer.messages.index') }}" @click="sidebarOpen = false">
                            <svg class="size-3 sm:size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            Messages
                            @if($unreadMessages > 0)
                                <span class="ms-auto inline-flex items-center size-4 sm:size-5 justify-center rounded-full text-[8px] sm:text-[10px] font-bold bg-primary-500 text-white">{{ $unreadMessages }}</span>
                            @endif
                        </a>
                    </li>
                </ul>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <p class="px-3 text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Browse</p>
                    <ul class="space-y-1">
                        <li>
                            <a class="flex items-center gap-x-3 py-2 px-3 text-sm rounded-xl text-gray-600 font-medium hover:bg-gray-100 transition-all"
                               href="{{ route('properties.index') }}">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                Browse Properties
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="px-4 sm:px-6 py-4 sm:py-5 border-t border-gray-200">
                <div class="flex items-center gap-3">
                    <span class="size-9 rounded-full bg-primary-500 flex items-center justify-center text-white font-black text-sm flex-shrink-0">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold text-gray-800 truncate">{{ $user->name }}</p>
                        <p class="text-[10px] text-gray-400 font-medium truncate">{{ $user->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="size-8 flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Sign out">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Content wrapper --}}
        <div class="w-full lg:ps-64">

            {{-- Header --}}
            <header class="sticky top-0 inset-x-0 flex flex-wrap sm:justify-start sm:flex-nowrap z-[48] bg-white/80 backdrop-blur-md border-b border-gray-200 py-3">
                <nav class="flex items-center justify-between w-full px-4 sm:px-6">
                    <div class="lg:hidden">
                        <button type="button" class="text-gray-500 hover:text-gray-600" @click="sidebarOpen = !sidebarOpen">
                            <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-x-4 ms-auto">
                        <a href="{{ route('properties.index') }}" class="hidden sm:inline-flex items-center gap-2 py-2 px-3 text-sm font-medium text-gray-600 hover:text-primary-600 transition-colors">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                            Browse Properties
                        </a>
                        {{-- Preline Dropdown — Notifications --}}
                        <div class="hs-dropdown relative inline-flex [--placement:bottom-right]">
                            <button id="dropdown-notifications" type="button"
                                class="hs-dropdown-toggle relative p-2.5 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-all">
                                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="absolute top-1.5 right-1.5 size-2 rounded-full" style="background:#3b65ad;"></span>
                                @endif
                            </button>
                            <div class="hs-dropdown-menu transition-[opacity,margin] hs-dropdown-open:opacity-100 opacity-0 hidden w-80 bg-white shadow-xl rounded-2xl border border-gray-100 mt-2 z-50 overflow-hidden"
                                 aria-labelledby="dropdown-notifications">
                                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                    <p class="text-sm font-black text-gray-800">Notifications</p>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <span class="inline-flex items-center py-0.5 px-2 rounded-full text-[10px] font-bold text-white bg-primary-500">{{ auth()->user()->unreadNotifications->count() }} New</span>
                                    @endif
                                </div>
                                <div class="divide-y divide-gray-50 max-h-72 overflow-y-auto">
                                    @forelse(auth()->user()->notifications()->take(5)->get() as $notification)
                                        <div class="flex items-start gap-3 px-4 py-3 {{ $notification->read_at ? 'opacity-60' : 'hover:bg-gray-50 transition-colors' }}">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-800">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                                <p class="text-xs text-gray-400 mt-0.5">{{ $notification->data['message'] ?? '' }}</p>
                                                <p class="text-[10px] text-gray-300 font-semibold mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                            @if(!$notification->read_at)
                                                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="mt-1 size-2 rounded-full flex-shrink-0 bg-primary-500 hover:bg-primary-600 transition-colors" title="Mark as read"></button>
                                                </form>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="px-4 py-6 text-center">
                                            <p class="text-sm text-gray-500 font-medium">No notifications available</p>
                                        </div>
                                    @endforelse
                                </div>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <div class="px-4 py-3 border-t border-gray-100">
                                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="block text-center">
                                            @csrf
                                            <button type="submit" class="text-xs font-bold text-primary-500 hover:text-primary-600 transition-colors">Mark all as read</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            {{-- Flash messages --}}
            @if(session('success') || session('error'))
                <div class="px-4 sm:px-6 pt-4">
                    @if(session('success'))
                        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm font-medium">{{ session('error') }}</div>
                    @endif
                </div>
            @endif

            {{-- Page content --}}
            <div class="p-6 sm:p-8 space-y-8">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.js"></script>
    @stack('scripts')
</body>
</html>
