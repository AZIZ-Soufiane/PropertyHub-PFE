@extends('layouts.frontend')

@section('content')
<!-- Header -->
<header class="flex flex-wrap sm:justify-start sm:flex-nowrap z-50 w-full bg-white/80 backdrop-blur-md border-b border-gray-200 py-3 sticky top-0">
    <nav class="max-w-7xl w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <a class="text-2xl font-black tracking-tighter text-primary-500" href="/">PropertyHub</a>
        </div>
        <div class="hidden sm:flex items-center gap-x-8">
            <a class="font-semibold text-gray-600 hover:text-blue-600 transition-colors" href="/">Home</a>
            <a class="font-bold text-blue-600" href="{{ route('properties.index') }}">Properties</a>
            <a class="font-semibold text-gray-600 hover:text-blue-600 transition-colors" href="{{ route('compare') }}">Compare</a>
            @auth
                <a class="py-2 px-4 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 transition-all" href="{{ route('dashboard') }}">Dashboard</a>
            @else
                <a class="py-2 px-4 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-black transition-all" href="{{ route('login') }}">Log in</a>
            @endauth
        </div>
    </nav>
</header>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Sidebar Filters -->
        <div class="w-full lg:w-1/4">
            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100 sticky top-24">
                <h3 class="text-xl font-bold text-gray-800 mb-8">Refine Search</h3>

                <form action="{{ route('properties.search') }}" method="GET" class="space-y-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <input type="text" name="location" value="{{ request('location') }}" placeholder="e.g. Malibu, CA"
                            class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-600 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Property Type</label>
                        <select name="type" class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-600">
                            <option value="">All Types</option>
                            <option value="villa" {{ request('type') == 'villa' ? 'selected' : '' }}>Villa</option>
                            <option value="penthouse" {{ request('type') == 'penthouse' ? 'selected' : '' }}>Penthouse</option>
                            <option value="apartment" {{ request('type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                            <option value="house" {{ request('type') == 'house' ? 'selected' : '' }}>House</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                                class="py-3 px-4 border border-gray-200 rounded-xl text-sm">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                                class="py-3 px-4 border border-gray-200 rounded-xl text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bedrooms</label>
                        <select name="bedrooms" class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm">
                            <option value="">Any</option>
                            <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1+</option>
                            <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2+</option>
                            <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3+</option>
                            <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4+</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-3 px-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all">
                        Find Properties
                    </button>
                </form>
            </div>
        </div>

        <!-- Properties Grid -->
        <div class="w-full lg:w-3/4">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-black text-gray-800">Discover Homes</h2>
                    <p class="text-gray-500 font-medium">{{ $properties->total() ?? 0 }} properties found</p>
                </div>
                <div>
                    <select onchange="window.location.href = '{{ route('properties.index') }}?sort=' + this.value" class="py-2 px-4 border border-gray-200 rounded-xl text-sm font-semibold bg-white">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                @forelse($properties as $property)
                    <div class="group flex flex-col bg-white border border-gray-50 shadow-sm rounded-3xl overflow-hidden hover:shadow-2xl transition-all duration-700">
                        <div class="h-80 overflow-hidden relative">
                            <img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                                src="{{ $property->images->first()?->first_url ?? 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800' }}"
                                alt="{{ $property->title }}">
                            @if($property->type)
                                <div class="absolute top-6 left-6">
                                    <span class="bg-white/90 backdrop-blur-md text-gray-900 text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest">{{ $property->type }}</span>
                                </div>
                            @endif
                            <div class="absolute top-6 right-6">
                                <button onclick="toggleFavorite({{ $property->id }})" 
                                    class="p-2.5 bg-white/90 backdrop-blur-sm rounded-full text-gray-400 hover:text-rose-500 shadow-sm transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="p-10">
                            <h3 class="text-2xl font-black text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                <a href="{{ route('properties.show', $property) }}">{{ $property->title }}</a>
                            </h3>
                            <div class="flex items-center gap-2 text-sm text-gray-400 font-bold mb-8">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                {{ $property->city }}, {{ $property->country }}
                            </div>
                            <div class="flex items-center justify-between mb-8">
                                <span class="text-3xl font-black text-blue-600">${{ number_format($property->price) }}</span>
                                <div class="flex gap-x-6">
                                    <div>
                                        <span class="block text-gray-400 text-[10px] uppercase font-black tracking-widest">Beds</span>
                                        <span class="font-black text-gray-900">{{ $property->bedrooms }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-gray-400 text-[10px] uppercase font-black tracking-widest">Baths</span>
                                        <span class="font-black text-gray-900">{{ $property->bathrooms }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-gray-400 text-[10px] uppercase font-black tracking-widest">Sqft</span>
                                        <span class="font-black text-gray-900">{{ number_format($property->area) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('properties.show', $property) }}" class="py-4 text-center text-sm font-black rounded-3xl bg-gray-50 text-gray-900 group-hover:bg-blue-600 group-hover:text-white transition-all">Details</a>
                                <a href="{{ route('compare') }}?id={{ $property->id }}" class="py-4 text-center text-sm font-black rounded-3xl border border-gray-100 text-gray-600 hover:border-blue-600 hover:text-blue-600 transition-all">Compare</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-12">
                        <p class="text-gray-500">No properties found matching your criteria.</p>
                    </div>
                @endforelse
            </div>

            @if($properties->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $properties->links() }}
                </div>
            @endif
        </div>
    </div>
</main>
@endsection