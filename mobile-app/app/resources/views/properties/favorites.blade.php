@extends('layouts.app')

@section('title', 'Favorites - PropertyHub Mobile')

@section('header')
    <h1 class="text-4xl font-bold">My Favorites</h1>
    <p class="text-xl text-blue-100 mt-2">Your saved properties</p>
@endsection

@section('content')
<div class="space-y-6">
    @if(empty($properties))
        <div class="card p-12 text-center">
            <h2 class="text-2xl font-semibold text-slate-900 mb-4">No Favorites Yet</h2>
            <p class="text-slate-600 mb-6">Start exploring and save your favorite properties</p>
            <a href="{{ route('properties.index') }}" class="btn-primary">
                Browse Properties
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($properties as $property)
                <div class="card overflow-hidden hover:shadow-lg transition-shadow">
                    <!-- Image -->
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $property['images'][0] ?? 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800' }}"
                             alt="{{ $property['title'] ?? 'Property' }}"
                             class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4 bg-rose-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            Saved
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $property['location'] ?? 'Property' }}</h3>
                        
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-primary-500">${{ number_format($property['price'] ?? 0, 0) }}</span>
                        </div>

                        <a href="{{ route('properties.show', $property['id']) }}" class="w-full btn-primary text-center block">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
