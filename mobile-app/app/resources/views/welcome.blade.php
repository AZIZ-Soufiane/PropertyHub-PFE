@extends('layouts.app')

@section('title', 'PropertyHub - Find Your Perfect Property')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center hero-pattern">
    <div class="relative max-w-5xl mx-auto px-4 text-center z-10">
        <span class="inline-block py-2 px-4 bg-blue-600/10 text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-6 border border-white/10 backdrop-blur-md">
            Premium Real Estate
        </span>
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white mb-6 tracking-tighter leading-[0.9]">
            Find Your <br class="hidden md:inline" /> <span class="text-blue-400">Dream Haven.</span>
        </h1>
        <p class="text-base text-white/70 mb-8 max-w-2xl mx-auto font-medium leading-relaxed">
            A sophisticated platform to search, compare, and manage verified premium listings across the globe.
        </p>

        <!-- Search Form -->
        <form action="{{ route('properties.search') }}" method="GET" class="glass-dark p-2 rounded-2xl max-w-4xl mx-auto">
            <div class="flex flex-col sm:flex-row">
                <div class="flex-1 px-6 py-4 text-left border-b sm:border-b-0 sm:border-r border-white/10">
                    <label class="block text-[10px] font-black text-white/50 uppercase tracking-widest mb-1">Location</label>
                    <input type="text" name="search" placeholder="e.g. Malibu, CA" 
                        class="bg-transparent text-white font-semibold text-sm outline-none w-full placeholder:text-white/30 border-none p-0 focus:ring-0">
                </div>
                <div class="flex-1 px-6 py-4 text-left border-b sm:border-b-0 sm:border-r border-white/10">
                    <label class="block text-[10px] font-black text-white/50 uppercase tracking-widest mb-1">Property Type</label>
                    <select name="type" class="bg-transparent text-white font-semibold text-sm outline-none border-none p-0 focus:ring-0 w-full">
                        <option value="" class="text-gray-800">All Types</option>
                        <option value="villa" class="text-gray-800">Villa</option>
                        <option value="penthouse" class="text-gray-800">Penthouse</option>
                        <option value="apartment" class="text-gray-800">Apartment</option>
                        <option value="house" class="text-gray-800">House</option>
                    </select>
                </div>
                <div class="flex-1 px-6 py-4 text-left border-b sm:border-b-0 sm:border-r border-white/10">
                    <label class="block text-[10px] font-black text-white/50 uppercase tracking-widest mb-1">Price Range</label>
                    <select name="price_range" class="bg-transparent text-white font-semibold text-sm outline-none border-none p-0 focus:ring-0 w-full">
                        <option value="" class="text-gray-800">Any Price</option>
                        <option value="0-500000" class="text-gray-800">Under $500K</option>
                        <option value="500000-1000000" class="text-gray-800">$500K - $1M</option>
                        <option value="1000000-5000000" class="text-gray-800">$1M - $5M</option>
                        <option value="5000000+" class="text-gray-800">$5M+</option>
                    </select>
                </div>
                <div class="p-2 flex items-stretch">
                    <button type="submit" class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-black px-8 py-4 rounded-xl transition-all w-full sm:w-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Featured Listings -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <span class="text-blue-600 font-black text-[10px] uppercase tracking-widest mb-2 block">Our Collection</span>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tighter">Exclusive Listings</h2>
            </div>
            <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-2 text-sm font-black text-gray-900 px-6 py-3 border border-gray-100 rounded-xl hover:bg-gray-50 transition-all">
                View All
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $featured = [
                    ['title' => 'The Glass House', 'location' => 'Austin, Texas', 'price' => 850000, 'beds' => 4, 'baths' => 3, 'area' => 3200, 'type' => 'Modern'],
                    ['title' => 'Sunset Villa', 'location' => 'Malibu, California', 'price' => 1200000, 'beds' => 5, 'baths' => 4, 'area' => 4800, 'type' => 'Villa'],
                    ['title' => 'Oceanview Retreat', 'location' => 'Santa Monica, CA', 'price' => 1850000, 'beds' => 6, 'baths' => 5, 'area' => 5200, 'type' => 'Luxury'],
                ];
            @endphp
            @foreach($featured as $property)
                <div class="group flex flex-col bg-white border border-gray-50 shadow-sm rounded-3xl overflow-hidden hover:shadow-2xl transition-all duration-700">
                    <div class="h-64 overflow-hidden relative">
                        <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center transition-transform duration-1000 group-hover:scale-110">
                            <svg class="w-24 h-24 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9"></path>
                            </svg>
                        </div>
                        <div class="absolute top-6 left-6">
                            <span class="bg-white/90 backdrop-blur-md text-gray-900 text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest">{{ $property['type'] }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                            <a href="{{ route('properties.show', $loop->iteration) }}">{{ $property['title'] }}</a>
                        </h3>
                        <div class="flex items-center gap-2 text-sm text-gray-400 font-bold mb-4">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            {{ $property['location'] }}
                        </div>
                        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                            <span class="text-2xl font-black text-blue-600">${{ number_format($property['price']) }}</span>
                            <div class="flex gap-6">
                                <div class="text-sm font-bold">
                                    <span class="block text-gray-400 text-[10px] uppercase font-black tracking-widest">Beds</span>{{ $property['beds'] }}
                                </div>
                                <div class="text-sm font-bold">
                                    <span class="block text-gray-400 text-[10px] uppercase font-black tracking-widest">Baths</span>{{ $property['baths'] }}
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('properties.show', $loop->iteration) }}" class="mt-2 w-full py-3 block text-center text-sm bg-gray-50 text-gray-900 font-black rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-all">
                            Explore Property
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.hero-pattern {
    background-image: linear-gradient(to bottom, rgba(15, 23, 42, 0.4), rgba(15, 23, 42, 0.6)), url('https://images.unsplash.com/photo-1600585154340-be6199f7d009?auto=format&fit=crop&w=1920&q=80');
    background-size: cover;
    background-position: center;
}
.glass-dark {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}
</style>
@endpush