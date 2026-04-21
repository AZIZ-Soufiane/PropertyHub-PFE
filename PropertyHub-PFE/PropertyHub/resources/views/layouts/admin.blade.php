<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Dashboard - PropertyHub' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-gray-50 text-gray-800 font-sans antialiased">
    <div class="min-h-screen flex">
        <aside class="fixed top-0 start-0 bottom-0 w-64 bg-white border-e border-gray-200 flex flex-col pt-6 pb-10 z-50 hidden lg:flex">
            <div class="px-6 mb-8">
                <a class="text-2xl font-black tracking-tighter text-primary-500" href="/">PropertyHub</a>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2">Admin Portal</p>
            </div>
            
            <nav class="px-6 flex-1">
                <ul class="space-y-1">
                    <li>
                        <a class="flex items-center gap-3.5 py-2.5 px-3 text-sm font-bold rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}"
                           href="{{ route('admin.dashboard') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <rect width="18" height="18" x="3" y="3" rx="2" />
                                <line x1="3" x2="21" y1="9" y2="9" />
                                <line x1="9" x2="9" y1="21" y2="9" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-3.5 py-2.5 px-3 text-sm font-medium rounded-xl text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.users.*') ? 'bg-gray-100' }}"
                           href="{{ route('admin.users.index') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                            </svg>
                            Users & Roles
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-3.5 py-2.5 px-3 text-sm font-medium rounded-xl text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.properties.*') ? 'bg-gray-100' }}"
                           href="{{ route('properties.index') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                <polyline points="9 22 9 12 15 12 15 22" />
                            </svg>
                            Properties
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="px-6 mt-auto pt-6 border-t border-gray-100">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full py-2 px-3 text-sm font-medium rounded-xl text-gray-700 hover:bg-gray-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" x2="9" y1="12" y2="12" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>
        <div class="flex-1 lg:ps-64">
            <header class="sticky top-0 z-40 bg-white border-b border-gray-200 py-4 px-6 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-black text-gray-800">Admin Dashboard</h1>
                </div>
                <div class="flex items-center gap-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="py-2 px-4 text-sm font-bold rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50">
                            Logout
                        </button>
                    </form>
                </div>
            </header>
            <main class="p-6 sm:p-8 space-y-8">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>