@extends('layouts.app')

@section('title', 'PropertyHub - Find Your Perfect Property')

@section('content')
<!-- Hero Section -->
<div class="w-full bg-gradient-to-r from-primary-600 to-primary-700 px-4 py-12 rounded-2xl mt-4 mb-8">
    <div class="max-w-full">
        <h1 class="text-3xl font-black text-white mb-2 tracking-tight">Find Your Dream Property</h1>
        <p class="text-primary-50 text-sm mb-6">Discover exclusive real estate opportunities</p>
        
        <!-- Quick Search Bar -->
        <div class="bg-white rounded-xl p-4 space-y-3">
            <input type="text" placeholder="Search location..." 
                   class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
            
            <div class="grid grid-cols-2 gap-3">
                <input type="number" placeholder="Min Price" 
                       class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
                <input type="number" placeholder="Max Price" 
                       class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
            </div>
            
            <a href="{{ route('properties.index') }}" class="block text-center bg-primary-600 text-white font-semibold py-2.5 rounded-lg hover:bg-primary-700 transition-smooth">
                Search Properties
            </a>
        </div>
    </div>
</div>

<!-- Featured Properties Section -->
<div class="px-4 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Featured Properties</h2>
        <a href="{{ route('properties.index') }}" class="text-primary-600 text-sm font-semibold hover:text-primary-700 transition-smooth">View All →</a>
    </div>

    <!-- Property Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Property Card 1 -->
        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-smooth group cursor-pointer">
            <div class="relative h-40 bg-gradient-to-br from-primary-400 to-primary-500 overflow-hidden">
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9"></path>
                    </svg>
                </div>
                <span class="absolute top-3 right-3 bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full">Sale</span>
            </div>
            <div class="p-4">
                <div class="flex items-start justify-between mb-2">
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm line-clamp-2">Modern Luxury Villa</h3>
                        <p class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                            New York, USA
                        </p>
                    </div>
                    <button class="p-2 hover:bg-slate-100 rounded-lg transition-smooth">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-2 pb-4 border-b border-slate-100">
                    <p class="text-xl font-black text-primary-600">$850,000</p>
                    <div class="flex items-center gap-4 text-xs text-slate-600">
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5"></path><path d="M6.5 10h7M6.5 13h4"></path></svg>
                            4 Rooms
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path><path d="M3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h1a1 1 0 001-1v-6a1 1 0 00-1-1h-1z"></path></svg>
                            2 Baths
                        </span>
                    </div>
                </div>
                
                <a href="{{ route('properties.show', ['id' => 1]) }}" class="block text-center w-full mt-4 bg-primary-600 text-white font-semibold py-2 rounded-lg hover:bg-primary-700 transition-smooth text-sm">
                    View Details
                </a>
            </div>
        </div>

        <!-- Property Card 2 -->
        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-smooth group cursor-pointer">
            <div class="relative h-40 bg-gradient-to-br from-blue-400 to-blue-500 overflow-hidden">
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9"></path>
                    </svg>
                </div>
                <span class="absolute top-3 right-3 bg-amber-500 text-white text-xs font-bold px-3 py-1 rounded-full">Pending</span>
            </div>
            <div class="p-4">
                <div class="flex items-start justify-between mb-2">
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm line-clamp-2">Contemporary Apartment</h3>
                        <p class="text-xs text-slate-500 flex items-center gap-1 mt-1">
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