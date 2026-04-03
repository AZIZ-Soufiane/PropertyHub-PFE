@extends('layouts.app')

@section('title', 'Browse Properties - PropertyHub')

@section('content')
<!-- Refine Search Section -->
<div class="sticky top-16 z-40 bg-white px-4 pt-6 pb-4 border-b border-slate-100 shadow-sm">
    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wide mb-4">Refine Search</h2>
    
    <form action="{{ route('properties.index') }}" method="GET" class="space-y-3">
        <!-- Location Input -->
        <input type="text" name="search" value="{{ request('search', '') }}" 
               placeholder="e.g. Malibu, CA" 
               class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">

        <!-- Property Type -->
        <select name="type" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
            <option value="">All Types</option>
            <option value="villa">Villa</option>
            <option value="apartment">Apartment</option>
            <option value="house">House</option>
        </select>

        <!-- Price Range Grid -->
        <div class="grid grid-cols-2 gap-3">
            <input type="number" name="min_price" value="{{ request('min_price', '') }}" 
                   placeholder="Min" 
                   class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
            <input type="number" name="max_price" value="{{ request('max_price', '') }}" 
                   placeholder="Max" 
                   class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
        </div>

        <!-- Status Filter -->
        <select name="status" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
            <option value="">All Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>Sold</option>
        </select>

        <!-- Search Button -->
        <button type="submit" class="w-full bg-primary-600 text-white font-bold py-3 rounded-lg hover:bg-primary-700 transition-smooth text-sm">
            Find Properties
        </button>
    </form>
</div>

<!-- Results Header -->
<div class="px-4 pt-6 pb-4">
    <h1 class="text-3xl font-black text-slate-900 mb-1">Discover Homes</h1>
    <p class="text-sm text-slate-600">124 properties found in Malibu</p>
</div>

<!-- Properties Grid -->
<div class="px-4 space-y-6 pb-12">
    <!-- Property Card 1 -->
    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all group">
        <div class="relative h-48 bg-gradient-to-br from-blue-400 to-blue-500 overflow-hidden">
            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-400/20 to-blue-600/40">
                <svg class="w-24 h-24 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9"></path>
                </svg>
            </div>
            <span class="absolute top-3 left-3 bg-white/90 text-slate-900 text-xs font-black px-3 py-1.5 rounded-full">VILLA</span>
            <button class="absolute top-3 right-3 p-2.5 bg-white rounded-full hover:scale-110 transition-transform shadow-md">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </button>
        </div>
        <div class="p-5">
            <h3 class="font-black text-slate-900 text-lg mb-1">Sunset Villa</h3>
            <p class="text-sm text-slate-600 flex items-center gap-1 mb-3">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                Malibu, California
            </p>
            
            <div class="pb-4 border-b border-slate-100 mb-4">
                <p class="text-2xl font-black text-primary-600">$1.2M</p>
                <div class="grid grid-cols-3 gap-3 text-center mt-3">
                    <div>
                        <p class="text-xs text-slate-600 font-bold">BEDS</p>
                        <p class="text-lg font-black text-slate-900">4</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 font-bold">BATHS</p>
                        <p class="text-lg font-black text-slate-900">3</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 font-bold">SQFT</p>
                        <p class="text-lg font-black text-slate-900">3.2K</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('properties.show', ['id' => 1]) }}" class="text-center px-4 py-2.5 border-2 border-primary-600 text-primary-600 font-bold rounded-lg hover:bg-primary-50 transition-colors text-sm">
                    Details
                </a>
                <button class="text-center px-4 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-lg hover:bg-slate-200 transition-colors text-sm">
                    Compare
                </button>
            </div>
        </div>
    </div>

    <!-- Property Card 2 -->
    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all group">
        <div class="relative h-48 bg-gradient-to-br from-amber-400 to-amber-500 overflow-hidden">
            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-amber-400/20 to-amber-600/40">
                <svg class="w-24 h-24 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9"></path>
                </svg>
            </div>
            <span class="absolute top-3 left-3 bg-white/90 text-slate-900 text-xs font-black px-3 py-1.5 rounded-full">MODERN</span>
            <button class="absolute top-3 right-3 p-2.5 bg-white rounded-full hover:scale-110 transition-transform shadow-md">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </button>
        </div>
        <div class="p-5">
            <h3 class="font-black text-slate-900 text-lg mb-1">The Glass House</h3>
            <p class="text-sm text-slate-600 flex items-center gap-1 mb-3">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                Austin, Texas
            </p>
            
            <div class="pb-4 border-b border-slate-100 mb-4">
                <p class="text-2xl font-black text-primary-600">$850K</p>
                <div class="grid grid-cols-3 gap-3 text-center mt-3">
                    <div>
                        <p class="text-xs text-slate-600 font-bold">BEDS</p>
                        <p class="text-lg font-black text-slate-900">4</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 font-bold">BATHS</p>
                        <p class="text-lg font-black text-slate-900">3</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 font-bold">SQFT</p>
                        <p class="text-lg font-black text-slate-900">2.7K</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('properties.show', ['id' => 2]) }}" class="text-center px-4 py-2.5 border-2 border-primary-600 text-primary-600 font-bold rounded-lg hover:bg-primary-50 transition-colors text-sm">
                    Details
                </a>
                <button class="text-center px-4 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-lg hover:bg-slate-200 transition-colors text-sm">
                    Compare
                </button>
            </div>
        </div>
    </div>

    <!-- Property Card 3 -->
    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all group">
        <div class="relative h-48 bg-gradient-to-br from-emerald-400 to-emerald-500 overflow-hidden">
            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-emerald-400/20 to-emerald-600/40">
                <svg class="w-24 h-24 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9"></path>
                </svg>
            </div>
            <span class="absolute top-3 left-3 bg-white/90 text-slate-900 text-xs font-black px-3 py-1.5 rounded-full">LUXURY</span>
            <button class="absolute top-3 right-3 p-2.5 bg-white rounded-full hover:scale-110 transition-transform shadow-md">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </button>
        </div>
        <div class="p-5">
            <h3 class="font-black text-slate-900 text-lg mb-1">Oceanview Retreat</h3>
            <p class="text-sm text-slate-600 flex items-center gap-1 mb-3">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                Santa Monica, CA
            </p>
            
            <div class="pb-4 border-b border-slate-100 mb-4">
                <p class="text-2xl font-black text-primary-600">$1.85M</p>
                <div class="grid grid-cols-3 gap-3 text-center mt-3">
                    <div>
                        <p class="text-xs text-slate-600 font-bold">BEDS</p>
                        <p class="text-lg font-black text-slate-900">5</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 font-bold">BATHS</p>
                        <p class="text-lg font-black text-slate-900">4</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 font-bold">SQFT</p>
                        <p class="text-lg font-black text-slate-900">4.5K</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('properties.show', ['id' => 3]) }}" class="text-center px-4 py-2.5 border-2 border-primary-600 text-primary-600 font-bold rounded-lg hover:bg-primary-50 transition-colors text-sm">
                    Details
                </a>
                <button class="text-center px-4 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-lg hover:bg-slate-200 transition-colors text-sm">
                    Compare
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
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
