@extends('layouts.app')

@section('title', 'Compare Properties - PropertyHub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-black text-gray-900 mb-2">Compare Properties</h1>
        <p class="text-gray-500">Select up to 3 properties to compare side by side</p>
    </div>

    @if(count($compareProperties) > 0)
        <div class="overflow-x-auto">
            <table class="w-full bg-white rounded-2xl shadow-sm overflow-hidden">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left p-4 font-bold text-gray-500 uppercase text-sm">Property</th>
                        @foreach($compareProperties as $property)
                            <th class="p-4 text-center">
                                <img src="{{ $property['images'][0] ?? 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=400' }}"
                                     alt="{{ $property['title'] }}"
                                     class="w-full h-32 object-cover rounded-xl mb-2">
                                <a href="{{ route('properties.show', $property['id']) }}" class="text-blue-600 font-bold text-sm hover:underline">{{ $property['title'] }}</a>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100">
                        <td class="p-4 font-bold text-gray-500">Price</td>
                        @foreach($compareProperties as $property)
                            <td class="p-4 text-center text-2xl font-black text-blue-600">${{ number_format($property['price']) }}</td>
                        @endforeach
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="p-4 font-bold text-gray-500">Location</td>
                        @foreach($compareProperties as $property)
                            <td class="p-4 text-center text-sm">{{ $property['location'] }}</td>
                        @endforeach
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="p-4 font-bold text-gray-500">Bedrooms</td>
                        @foreach($compareProperties as $property)
                            <td class="p-4 text-center text-xl font-bold">{{ $property['bedrooms'] }}</td>
                        @endforeach
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="p-4 font-bold text-gray-500">Bathrooms</td>
                        @foreach($compareProperties as $property)
                            <td class="p-4 text-center text-xl font-bold">{{ $property['bathrooms'] }}</td>
                        @endforeach
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="p-4 font-bold text-gray-500">Area</td>
                        @foreach($compareProperties as $property)
                            <td class="p-4 text-center text-xl font-bold">{{ number_format($property['area']) }} sqft</td>
                        @endforeach
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="p-4 font-bold text-gray-500">Status</td>
                        @foreach($compareProperties as $property)
                            <td class="p-4 text-center">
                                <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm font-bold">{{ ucfirst($property['status']) }}</span>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="p-4 font-bold text-gray-500">Actions</td>
                        @foreach($compareProperties as $property)
                            <td class="p-4 text-center">
                                <a href="{{ route('properties.show', $property['id']) }}" class="text-blue-600 hover:underline text-sm">View Details</a>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-6 text-center">
            <a href="{{ route('compare.clear') }}" class="text-gray-500 hover:text-gray-700 text-sm">Clear comparison</a>
        </div>
    @else
        <div class="text-center py-16 bg-gray-50 rounded-2xl">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <h3 class="text-xl font-bold text-gray-700 mb-2">No properties to compare</h3>
            <p class="text-gray-500 mb-6">Browse our listings and add properties to compare</p>
            <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-2 py-3 px-6 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all text-sm">
                Browse Properties
            </a>
        </div>
    @endif
</div>
@endsection