@extends('layouts.app')

@section('title', 'Browse Properties - PropertyHub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filters -->
        <div class="w-full lg:w-1/4">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 sticky top-24">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Refine Search</h3>

                <form action="{{ route('properties.search') }}" method="GET" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <input type="text" name="search" value="{{ request('search', '') }}" placeholder="e.g. Malibu, CA"
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
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
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
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-black text-gray-800">Discover Homes</h2>
                    <p class="text-gray-500 font-medium text-sm">{{ count($properties) }} properties found</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($properties as $property)
                    <div class="group flex flex-col bg-white border border-gray-50 shadow-sm rounded-3xl overflow-hidden hover:shadow-2xl transition-all duration-700">
                        <div class="h-64 overflow-hidden relative">
                            <img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                                 src="{{ $property['images'][0] ?? 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800' }}"
                                 alt="{{ $property['title'] }}">
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-md text-gray-900 text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest">{{ $property['type'] ?? $property['status'] }}</span>
                            </div>
                            <a href="{{ route('compare.add') }}?id={{ $property['id'] }}" class="absolute top-4 right-4 p-2 bg-white/90 backdrop-blur-sm rounded-full text-gray-400 hover:text-blue-600 shadow-sm transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </a>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                <a href="{{ route('properties.show', $property['id']) }}">{{ $property['title'] }}</a>
                            </h3>
                            <div class="flex items-center gap-2 text-sm text-gray-400 font-bold mb-4">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                {{ $property['location'] }}
                            </div>
                            <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                                <span class="text-2xl font-black text-blue-600">${{ number_format($property['price']) }}</span>
                                <div class="flex gap-4">
                                    <div class="text-sm font-bold text-center">
                                        <span class="block text-gray-400 text-[10px] uppercase font-black tracking-widest">Beds</span>
                                        <span class="text-gray-900">{{ $property['bedrooms'] }}</span>
                                    </div>
                                    <div class="text-sm font-bold text-center">
                                        <span class="block text-gray-400 text-[10px] uppercase font-black tracking-widest">Baths</span>
                                        <span class="text-gray-900">{{ $property['bathrooms'] }}</span>
                                    </div>
                                    <div class="text-sm font-bold text-center">
                                        <span class="block text-gray-400 text-[10px] uppercase font-black tracking-widest">Sqft</span>
                                        <span class="text-gray-900">{{ number_format($property['area']) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('properties.show', $property['id']) }}" class="py-3 text-center text-sm font-black rounded-2xl bg-gray-50 text-gray-900 group-hover:bg-blue-600 group-hover:text-white transition-all">Details</a>
                                <a href="{{ route('compare.add') }}?id={{ $property['id'] }}" class="py-3 text-center text-sm font-black rounded-2xl border border-gray-100 text-gray-600 hover:border-blue-600 hover:text-blue-600 transition-all">Compare</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-12">
                        <p class="text-gray-500">No properties found matching your criteria.</p>
                        <a href="{{ route('properties.index') }}" class="text-blue-600 text-sm font-semibold mt-2 inline-block">Clear filters</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection