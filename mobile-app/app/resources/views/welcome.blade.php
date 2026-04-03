@extends('layouts.app')

@section('title', 'PropertyHub - Find Your Perfect Property')

@section('content')
<!-- Hero Section -->
<div class="w-full bg-gradient-to-br from-slate-600 to-slate-700 px-4 pt-8 pb-10 mb-8">
    <div class="max-w-full">
        <!-- Premium Badge -->
        <div class="inline-block bg-slate-700 text-white text-xs font-black px-3 py-1 rounded-full mb-4 tracking-widest">PREMIUM REAL ESTATE</div>
        
        <!-- Hero Headline -->
        <h1 class="text-3xl sm:text-4xl font-black text-white mb-2 tracking-tight">Find Your <span class="text-primary-400">Dream Haven</span>.</h1>
        <p class="text-slate-300 text-sm mb-6">A sophisticated platform to search, compare, and manage verified premium listings across the globe.</p>
        
        <!-- Search Form -->
        <div class="bg-white rounded-2xl p-5 space-y-4 shadow-lg">
            <!-- Location Input -->
            <div>
                <label class="text-xs font-bold text-slate-600 uppercase tracking-wide mb-2 block">Location</label>
                <input type="text" placeholder="e.g. Malibu, CA" 
                       class="w-full px-4 py-3 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
            </div>

            <!-- Property Type Select -->
            <div>
                <label class="text-xs font-bold text-slate-600 uppercase tracking-wide mb-2 block">Property Type</label>
                <select class="w-full px-4 py-3 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
                    <option>Select type...</option>
                    <option>Villa</option>
                    <option>Apartment</option>
                    <option>House</option>
                    <option>Land</option>
                </select>
            </div>

            <!-- Price Range -->
            <div>
                <label class="text-xs font-bold text-slate-600 uppercase tracking-wide mb-2 block">Price Range</label>
                <select class="w-full px-4 py-3 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
                    <option>Select range...</option>
                    <option>$0 - $500K</option>
                    <option>$500K - $1M</option>
                    <option>$1M - $2M</option>
                    <option>$2M+</option>
                </select>
            </div>
            
            <!-- Search Button -->
            <a href="{{ route('properties.index') }}" class="flex items-center justify-center gap-2 w-full bg-primary-600 text-white font-bold py-3 rounded-lg hover:bg-primary-700 transition-smooth text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                Search
            </a>
        </div>
    </div>
</div>

<!-- Exclusive Listings Section -->
<div class="px-4 mb-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs font-bold text-primary-600 uppercase tracking-widest mb-1">OUR COLLECTION</p>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900">Exclusive Listings</h2>
        </div>
        <a href="{{ route('properties.index') }}" class="text-primary-600 text-sm font-bold hover:text-primary-700 transition-smooth whitespace-nowrap">View All →</a>
    </div>

    <!-- Property Cards Grid -->
    <div class="space-y-5">
        <!-- Property Card 1 -->
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all group cursor-pointer">
            <div class="relative h-48 bg-gradient-to-br from-primary-400 to-primary-500 overflow-hidden">
                <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-400/20 to-blue-600/40">
                    <svg class="w-24 h-24 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9"></path>
                    </svg>
                </div>
                <span class="absolute top-3 left-3 bg-white/90 text-slate-900 text-xs font-black px-3 py-1.5 rounded-full">WEST LAKE</span>
                <button class="absolute top-3 right-3 p-2.5 bg-white rounded-full hover:scale-110 transition-transform shadow-md">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
            </div>
            <div class="p-5">
                <h3 class="font-black text-slate-900 text-lg mb-1">The Glass House</h3>
                <p class="text-sm text-slate-600 flex items-center gap-1 mb-4">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                    Austin, Texas
                </p>
                
                <div class="pb-4 border-b border-slate-100 mb-4">
                    <p class="text-2xl font-black text-primary-600 mb-3">$850,000</p>
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div>
                            <p class="text-xs text-slate-600 font-bold uppercase">BEDS</p>
                            <p class="text-lg font-black text-slate-900">4</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-bold uppercase">BATHS</p>
                            <p class="text-lg font-black text-slate-900">3</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-bold uppercase">SQFT</p>
                            <p class="text-lg font-black text-slate-900">3.2K</p>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('properties.show', ['id' => 1]) }}" class="block text-center w-full bg-primary-600 text-white font-bold py-2.5 rounded-lg hover:bg-primary-700 transition-smooth text-sm">
                    Explore Property
                </a>
            </div>
        </div>

        <!-- Property Card 2 -->
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all group cursor-pointer">
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
                <h3 class="font-black text-slate-900 text-lg mb-1">Sunset Villa</h3>
                <p class="text-sm text-slate-600 flex items-center gap-1 mb-4">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                    Malibu, California
                </p>
                
                <div class="pb-4 border-b border-slate-100 mb-4">
                    <p class="text-2xl font-black text-primary-600 mb-3">$1.2M</p>
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div>
                            <p class="text-xs text-slate-600 font-bold uppercase">BEDS</p>
                            <p class="text-lg font-black text-slate-900">5</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-bold uppercase">BATHS</p>
                            <p class="text-lg font-black text-slate-900">4</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-bold uppercase">SQFT</p>
                            <p class="text-lg font-black text-slate-900">4.8K</p>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('properties.show', ['id' => 2]) }}" class="block text-center w-full bg-primary-600 text-white font-bold py-2.5 rounded-lg hover:bg-primary-700 transition-smooth text-sm">
                    Explore Property
                </a>
            </div>
        </div>

        <!-- Property Card 3 -->
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all group cursor-pointer">
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
                <p class="text-sm text-slate-600 flex items-center gap-1 mb-4">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                    Santa Monica, CA
                </p>
                
                <div class="pb-4 border-b border-slate-100 mb-4">
                    <p class="text-2xl font-black text-primary-600 mb-3">$1.85M</p>
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div>
                            <p class="text-xs text-slate-600 font-bold uppercase">BEDS</p>
                            <p class="text-lg font-black text-slate-900">6</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-bold uppercase">BATHS</p>
                            <p class="text-lg font-black text-slate-900">5</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-bold uppercase">SQFT</p>
                            <p class="text-lg font-black text-slate-900">5.2K</p>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('properties.show', ['id' => 3]) }}" class="block text-center w-full bg-primary-600 text-white font-bold py-2.5 rounded-lg hover:bg-primary-700 transition-smooth text-sm">
                    Explore Property
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                            Los Angeles, USA
                        </p>
                    </div>
                    <button class="p-2 hover:bg-slate-100 rounded-lg transition-smooth">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-2 pb-4 border-b border-slate-100">
                    <p class="text-xl font-black text-primary-600">$450,000</p>
                    <div class="flex items-center gap-4 text-xs text-slate-600">
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5"></path><path d="M6.5 10h7M6.5 13h4"></path></svg>
                            3 Rooms
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path><path d="M3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h1a1 1 0 001-1v-6a1 1 0 00-1-1h-1z"></path></svg>
                            2 Baths
                        </span>
                    </div>
                </div>
                
                <a href="{{ route('properties.show', ['id' => 2]) }}" class="block text-center w-full mt-4 bg-primary-600 text-white font-semibold py-2 rounded-lg hover:bg-primary-700 transition-smooth text-sm">
                    View Details
                </a>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="px-4 mb-12">
    <div class="bg-primary-50 border-2 border-primary-200 rounded-xl p-6 text-center">
        <h3 class="text-lg font-bold text-primary-900 mb-2">Browse All Properties</h3>
        <p class="text-sm text-primary-700 mb-4">Explore our complete collection of premium properties</p>
        <a href="{{ route('properties.index') }}" class="inline-block bg-primary-600 text-white font-semibold py-2.5 px-6 rounded-lg hover:bg-primary-700 transition-smooth text-sm">
            View All Properties →
        </a>
    </div>
</div>
@endsection