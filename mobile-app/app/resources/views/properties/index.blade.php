@extends('layouts.app')

@section('title', 'Browse Properties - PropertyHub')

@section('content')
<!-- Header -->
<div class="px-4 pt-6 pb-4">
    <h1 class="text-2xl font-black text-slate-900 mb-1">Browse Properties</h1>
    <p class="text-sm text-slate-600">Explore all available listings</p>
</div>

<!-- Search & Filter Section -->
<div class="px-4 mb-6 bg-white rounded-xl p-4 shadow-sm">
    <form action="{{ route('properties.index') }}" method="GET" class="space-y-3">
        <!-- Search Input -->
        <input type="text" name="search" value="{{ request('search', '') }}" 
               placeholder="Search location..." 
               class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">

        <!-- Price Range -->
        <div class="grid grid-cols-2 gap-3">
            <input type="number" name="min_price" value="{{ request('min_price', '') }}" 
                   placeholder="Min Price" 
                   class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
            <input type="number" name="max_price" value="{{ request('max_price', '') }}" 
                   placeholder="Max Price" 
                   class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
        </div>

        <!-- Status Filter -->
        <select name="status" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
            <option value="">All Properties</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>Sold</option>
        </select>

        <!-- Search Button -->
        <button type="submit" class="w-full bg-primary-600 text-white font-semibold py-2.5 rounded-lg hover:bg-primary-700 transition-smooth text-sm">
            Search
        </button>
    </form>
</div>

<!-- Results Count -->
<div class="px-4 mb-4">
    <p class="text-sm text-slate-600">Showing <span class="font-bold text-slate-900">25</span> properties</p>
</div>

<!-- Properties Grid -->
<div class="px-4 space-y-4 pb-12">
    <!-- Property Card 1 -->
    <a href="{{ route('properties.show', ['id' => 1]) }}" class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-smooth group no-underline block">
        <div class="relative h-48 bg-gradient-to-br from-primary-400 to-primary-500 flex items-center justify-center">
            <svg class="w-24 h-24 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9"></path>
            </svg>
            <span class="absolute top-3 right-3 bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full">Sale</span>
        </div>
        <div class="p-4">
            <div class="flex items-start justify-between mb-2">
                <div class="flex-1">
                    <h3 class="font-bold text-slate-900 text-sm group-hover:text-primary-600 transition-smooth">Modern Luxury Villa</h3>
                    <p class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                        New York, USA
                    </p>
                </div>
                <button class="p-2 hover:bg-slate-100 rounded-lg transition-smooth flex-shrink-0">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-primary-600 transition-smooth" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
            </div>
            
            <div class="pb-4 border-b border-slate-100">
                <p class="text-lg font-black text-primary-600">$850,000</p>
                <div class="flex items-center gap-4 text-xs text-slate-600 mt-2">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5"></path><path d="M6.5 10h7M6.5 13h4"></path></svg>
                        4 Rooms
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path><path d="M3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h1a1 1 0 001-1v-6a1 1 0 00-1-1h-1z"></path></svg>
                        2 Baths
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H3.75a2.25 2.25 0 00-2.25 2.25v12.5a2.25 2.25 0 002.25 2.25h12.5a2.25 2.25 0 002.25-2.25V3.75a2.25 2.25 0 00-2.25-2.25zm0 15H3.75v-12.5h12.5v12.5z"></path></svg>
                        3800 sqft
                    </span>
                </div>
            </div>
            
            <p class="text-xs text-slate-600 mt-3">Listed by John Smith</p>
        </div>
    </a>

    <!-- Property Card 2 -->
    <a href="{{ route('properties.show', ['id' => 2]) }}" class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-smooth group no-underline block">
        <div class="relative h-48 bg-gradient-to-br from-blue-400 to-blue-500 flex items-center justify-center">
            <svg class="w-24 h-24 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9"></path>
            </svg>
            <span class="absolute top-3 right-3 bg-amber-500 text-white text-xs font-bold px-3 py-1 rounded-full">Pending</span>
        </div>
        <div class="p-4">
            <div class="flex items-start justify-between mb-2">
                <div class="flex-1">
                    <h3 class="font-bold text-slate-900 text-sm group-hover:text-primary-600 transition-smooth">Contemporary Apartment</h3>
                    <p class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                        Los Angeles, USA
                    </p>
                </div>
                <button class="p-2 hover:bg-slate-100 rounded-lg transition-smooth flex-shrink-0">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-primary-600 transition-smooth" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
            </div>
            
            <div class="pb-4 border-b border-slate-100">
                <p class="text-lg font-black text-primary-600">$450,000</p>
                <div class="flex items-center gap-4 text-xs text-slate-600 mt-2">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5"></path><path d="M6.5 10h7M6.5 13h4"></path></svg>
                        3 Rooms
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path><path d="M3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h1a1 1 0 001-1v-6a1 1 0 00-1-1h-1z"></path></svg>
                        2 Baths
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H3.75a2.25 2.25 0 00-2.25 2.25v12.5a2.25 2.25 0 002.25 2.25h12.5a2.25 2.25 0 002.25-2.25V3.75a2.25 2.25 0 00-2.25-2.25zm0 15H3.75v-12.5h12.5v12.5z"></path></svg>
                        2200 sqft
                    </span>
                </div>
            </div>
            
            <p class="text-xs text-slate-600 mt-3">Listed by Sarah Johnson</p>
        </div>
    </a>

    <!-- Property Card 3 -->
    <a href="{{ route('properties.show', ['id' => 3]) }}" class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-smooth group no-underline block">
        <div class="relative h-48 bg-gradient-to-br from-purple-400 to-purple-500 flex items-center justify-center">
            <svg class="w-24 h-24 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9"></path>
            </svg>
            <span class="absolute top-3 right-3 bg-slate-500 text-white text-xs font-bold px-3 py-1 rounded-full">Sold</span>
        </div>
        <div class="p-4">
            <div class="flex items-start justify-between mb-2">
                <div class="flex-1">
                    <h3 class="font-bold text-slate-900 text-sm group-hover:text-primary-600 transition-smooth">Cozy Family Home</h3>
                    <p class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                        Chicago, USA
                    </p>
                </div>
                <button class="p-2 hover:bg-slate-100 rounded-lg transition-smooth flex-shrink-0">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-primary-600 transition-smooth" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
            </div>
            
            <div class="pb-4 border-b border-slate-100">
                <p class="text-lg font-black text-slate-400 line-through">$350,000</p>
                <div class="flex items-center gap-4 text-xs text-slate-600 mt-2">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5"></path><path d="M6.5 10h7M6.5 13h4"></path></svg>
                        3 Rooms
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path><path d="M3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h1a1 1 0 001-1v-6a1 1 0 00-1-1h-1z"></path></svg>
                        1.5 Baths
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H3.75a2.25 2.25 0 00-2.25 2.25v12.5a2.25 2.25 0 002.25 2.25h12.5a2.25 2.25 0 002.25-2.25V3.75a2.25 2.25 0 00-2.25-2.25zm0 15H3.75v-12.5h12.5v12.5z"></path></svg>
                        1800 sqft
                    </span>
                </div>
            </div>
            
            <p class="text-xs text-slate-600 mt-3">Listed by Michael Brown</p>
        </div>
    </a>

    <!-- Property Card 4 -->
    <a href="{{ route('properties.show', ['id' => 4]) }}" class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-smooth group no-underline block">
        <div class="relative h-48 bg-gradient-to-br from-indigo-400 to-indigo-500 flex items-center justify-center">
            <svg class="w-24 h-24 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9"></path>
            </svg>
            <span class="absolute top-3 right-3 bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full">Sale</span>
        </div>
        <div class="p-4">
            <div class="flex items-start justify-between mb-2">
                <div class="flex-1">
                    <h3 class="font-bold text-slate-900 text-sm group-hover:text-primary-600 transition-smooth">Penthouse Downtown</h3>
                    <p class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                        Miami, USA
                    </p>
                </div>
                <button class="p-2 hover:bg-slate-100 rounded-lg transition-smooth flex-shrink-0">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-primary-600 transition-smooth" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
            </div>
            
            <div class="pb-4 border-b border-slate-100">
                <p class="text-lg font-black text-primary-600">$1,250,000</p>
                <div class="flex items-center gap-4 text-xs text-slate-600 mt-2">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5"></path><path d="M6.5 10h7M6.5 13h4"></path></svg>
                        5 Rooms
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path><path d="M3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h1a1 1 0 001-1v-6a1 1 0 00-1-1h-1z"></path></svg>
                        3 Baths
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H3.75a2.25 2.25 0 00-2.25 2.25v12.5a2.25 2.25 0 002.25 2.25h12.5a2.25 2.25 0 002.25-2.25V3.75a2.25 2.25 0 00-2.25-2.25zm0 15H3.75v-12.5h12.5v12.5z"></path></svg>
                        4500 sqft
                    </span>
                </div>
            </div>
            
            <p class="text-xs text-slate-600 mt-3">Listed by Emily Davis</p>
        </div>
    </a>
</div>
@endsection
