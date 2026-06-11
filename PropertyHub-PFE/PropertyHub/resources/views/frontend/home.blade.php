@extends('layouts.frontend')

@section('content')
<!-- Header -->
<header class="fixed top-0 inset-x-0 z-50 w-full bg-white/80 border-b border-gray-100 py-4 backdrop-blur-xl">
    <nav class="max-w-7xl mx-auto px-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <a class="text-2xl font-black tracking-tighter text-primary-500" href="/">PropertyHub</a>
        </div>
        <div class="hidden sm:flex items-center gap-x-8">
            <a class="font-bold text-blue-600" href="/">Home</a>
            <a class="font-semibold text-gray-500 hover:text-blue-600 transition-colors" href="{{ route('properties.index') }}">Properties</a>
            <a class="font-semibold text-gray-500 hover:text-blue-600 transition-colors" href="{{ route('compare') }}">Compare</a>
            @auth
                <a class="font-semibold text-gray-500 hover:text-blue-600 transition-colors" href="{{ route('dashboard') }}">Dashboard</a>
            @else
                <a class="py-2.5 px-6 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-black transition-all" href="{{ route('login') }}">Sign In</a>
            @endauth
        </div>
    </nav>
</header>

<main>
    <!-- Hero Section -->
    @php
        $heroBgImage = 'https://images.unsplash.com/photo-1600585154340-be6199f7d009?auto=format&fit=crop&w=1920&q=80';
        if ($featuredProperties && $featuredProperties->isNotEmpty()) {
            $featured = $featuredProperties->first();
            $heroBgImage = $featured->images->first()?->first_url ?? $heroBgImage;
        }
    @endphp
    <section class="relative min-h-screen flex items-center justify-center hero-pattern"
        style="background-image: linear-gradient(to bottom, rgba(15,23,42,0.4), rgba(15,23,42,0.6)), url('{{ $heroBgImage }}');">
        <div class="relative max-w-5xl mx-auto px-4 text-center z-10">
            <span class="inline-block py-2 px-4 bg-blue-600/10 text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-6 border border-white/10 backdrop-blur-md">
                Premium Real Estate
            </span>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white mb-8 tracking-tighter leading-[0.9]">
                Find Your <br class="hidden md:inline" /> <span class="text-blue-400">Dream Haven.</span>
            </h1>
            <p class="text-lg text-white/70 mb-12 max-w-2xl mx-auto font-medium leading-relaxed">
                A sophisticated platform to search, compare, and manage verified premium listings across the globe.
            </p>

            <!-- Search Bar -->
            <form action="{{ route('properties.search') }}" method="GET" class="glass-dark p-2 rounded-2xl max-w-4xl mx-auto">
                <div class="flex flex-col sm:flex-row">
                    <div class="flex-1 px-6 py-4 text-left border-b sm:border-b-0 sm:border-r border-white/10">
                        <label class="block text-[10px] font-black text-white/50 uppercase tracking-widest mb-1">Location</label>
                        <input type="text" name="location" placeholder="e.g. Malibu, CA" 
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
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-end mb-16">
                <div>
                    <span class="text-blue-600 font-black text-[10px] uppercase tracking-widest mb-2 block">Our Collection</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tighter">Exclusive Listings</h2>
                </div>
                <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-2 text-sm font-black text-gray-900 px-6 py-3 border border-gray-100 rounded-xl hover:bg-gray-50 transition-all">
                    View All
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($featuredProperties ?? [] as $property)
                    <div class="group flex flex-col bg-white border border-gray-50 shadow-sm rounded-3xl overflow-hidden hover:shadow-2xl transition-all duration-700">
                        <div class="h-72 overflow-hidden relative">
                            <img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                                src="{{ $property->images->first()?->first_url ?? 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800' }}"
                                alt="{{ $property->title }}">
                            @if($property->type)
                                <div class="absolute top-6 left-6">
                                    <span class="bg-white/90 backdrop-blur-md text-gray-900 text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest">{{ $property->type }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-black text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                <a href="{{ route('properties.show', $property) }}">{{ $property->title }}</a>
                            </h3>
                            <div class="flex items-center gap-2 text-sm text-gray-400 font-bold mb-6">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                {{ $property->city }}, {{ $property->country }}
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-black text-blue-600">${{ number_format($property->price) }}</span>
                                <div class="flex gap-6">
                                    <div class="text-sm font-bold">
                                        <span class="block text-gray-400 text-[10px] uppercase font-black tracking-widest">Beds</span>{{ $property->bedrooms }}
                                    </div>
                                    <div class="text-sm font-bold">
                                        <span class="block text-gray-400 text-[10px] uppercase font-black tracking-widest">Baths</span>{{ $property->bathrooms }}
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('properties.show', $property) }}" class="mt-6 w-full py-4 block text-center text-sm bg-gray-50 text-gray-900 font-black rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-all">
                                Explore Property
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-3 text-center py-12">No featured properties available.</p>
                @endforelse
            </div>
        </div>
    </section>
</main>

<!-- Footer -->
<footer class="bg-slate-950 py-20 px-4 rounded-t-3xl">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
        <div>
            <a class="text-2xl font-black text-white mb-4 block tracking-tighter" href="/">Property<span class="text-blue-500">Hub.</span></a>
            <p class="text-gray-500 font-medium text-sm">Elevating the real estate experience through intelligent management and stunning presentation.</p>
        </div>
        <div>
            <h4 class="text-gray-400 font-black mb-4 text-[10px] uppercase tracking-widest">Quick Access</h4>
            <ul class="space-y-3 text-white font-bold text-sm">
                <li><a class="hover:text-blue-500 transition-colors" href="{{ route('properties.index') }}">Listings</a></li>
                <li><a class="hover:text-blue-500 transition-colors" href="{{ route('compare') }}">Comparison</a></li>
                <li><a class="hover:text-blue-500 transition-colors" href="{{ route('login') }}">Authentication</a></li>
            </ul>
        </div>
        <div class="md:col-span-2">
            <h4 class="text-gray-400 font-black mb-4 text-[10px] uppercase tracking-widest">Newsletter</h4>
            <form class="flex gap-2">
                <input type="email" placeholder="Your email" class="grow bg-white/5 border border-white/10 rounded-xl px-4 py-3 outline-none focus:border-blue-500 text-white font-bold text-sm">
                <button class="px-6 py-3 bg-white text-black font-bold text-sm rounded-xl hover:bg-gray-100 transition-all">Join</button>
            </form>
        </div>
    </div>
    <div class="max-w-7xl mx-auto border-t border-white/5 mt-16 pt-8 flex justify-between text-[10px] font-black text-gray-600 uppercase tracking-widest">
        <span>© {{ date('Y') }} PropertyHub</span>
        <span>Crafted by Solicode</span>
    </div>
</footer>
@endsection