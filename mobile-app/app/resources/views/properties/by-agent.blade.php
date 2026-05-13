@extends('layouts.app')

@section('title', 'Agent Properties - PropertyHub Mobile')

@section('header')
    <div>
        <h1 class="text-4xl font-bold">{{ $agent['name'] ?? 'Agent' }}'s Properties</h1>
        <p class="text-xl text-blue-100 mt-2">Explore all listings from this agent</p>
    </div>
@endsection

@section('content')
<div class="space-y-8">
    <!-- Agent Info Card -->
    @if(isset($agent))
        <div class="card p-6">
            <div class="flex items-center gap-6">
                <div>
                    @if(isset($agent['avatar']))
                        <img src="{{ $agent['avatar'] }}" alt="{{ $agent['name'] }}" class="w-24 h-24 rounded-full object-cover">
                    @else
                        <div class="w-24 h-24 rounded-full bg-primary-100 flex items-center justify-center text-3xl">👤</div>
                    @endif
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-slate-900">{{ $agent['name'] }}</h2>
                    <p class="text-slate-600">{{ $agent['email'] }}</p>
                    @if(isset($agent['phone']))
                        <p class="text-slate-600">{{ $agent['phone'] }}</p>
                    @endif
                    <a href="{{ route('appointments.book', $agent['id']) }}" class="mt-4 btn-primary inline-block">
                        Book Appointment
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Properties Grid -->
    <div>
        <h2 class="text-2xl font-bold text-slate-900 mb-6">Available Properties</h2>
        
        @if(empty($properties))
            <div class="card p-12 text-center">
                <p class="text-slate-600 text-lg">No properties available from this agent.</p>
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
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $property['location'] ?? 'Property' }}</h3>
                            
                            <div class="grid grid-cols-3 gap-4 mb-4 py-4 border-y border-slate-200">
                                <div class="text-center">
                                    <p class="text-xs text-slate-600">Bedrooms</p>
                                    <p class="font-semibold text-slate-900">{{ $property['bedrooms'] ?? 'N/A' }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-xs text-slate-600">Bathrooms</p>
                                    <p class="font-semibold text-slate-900">{{ $property['bathrooms'] ?? 'N/A' }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-xs text-slate-600">Area</p>
                                    <p class="font-semibold text-slate-900">{{ number_format($property['area'] ?? 0, 0) }}</p>
                                </div>
                            </div>

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
</div>
@endsection
