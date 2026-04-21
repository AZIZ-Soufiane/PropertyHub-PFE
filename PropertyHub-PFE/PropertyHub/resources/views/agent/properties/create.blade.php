@extends('layouts.agent')

@php
$isEdit = isset($property) && $property;
@endphp

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">{{ $isEdit ? 'Edit Property' : 'Add New Property' }}</h1>
    <p class="text-sm text-gray-500 mt-1">Fill in the details for your property listing</p>
</div>

<div class="bg-white border border-gray-200 rounded-3xl p-8">
    <form action="{{ $isEdit ? route('agent.properties.update', $property) : route('agent.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @if($isEdit) @method('PUT') @endif
        
        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Title *</label>
                <input type="text" name="title" value="{{ $property->title ?? old('title') }}" required
                    class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="e.g. Sunset Villa, Malibu">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Type *</label>
                <select name="type" required class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm">
                    <option value="">Select type</option>
                    <option value="villa" {{ ($property->type ?? '') === 'villa' ? 'selected' : '' }}>Villa</option>
                    <option value="apartment" {{ ($property->type ?? '') === 'apartment' ? 'selected' : '' }}>Apartment</option>
                    <option value="house" {{ ($property->type ?? '') === 'house' ? 'selected' : '' }}>House</option>
                    <option value="penthouse" {{ ($property->type ?? '') === 'penthouse' ? 'selected' : '' }}>Penthouse</option>
                    <option value="land" {{ ($property->type ?? '') === 'land' ? 'selected' : '' }}>Land</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Price ($) *</label>
                <input type="number" name="price" value="{{ $property->price ?? old('price') }}" required
                    class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="250000">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Area (sq ft) *</label>
                <input type="number" name="area" value="{{ $property->area ?? old('area') }}" required
                    class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="2500">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Bedrooms *</label>
                <input type="number" name="bedrooms" value="{{ $property->bedrooms ?? old('bedrooms', 1) }}" required min="1"
                    class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Bathrooms *</label>
                <input type="number" name="bathrooms" value="{{ $property->bathrooms ?? old('bathrooms', 1) }}" required min="1"
                    class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Country *</label>
                <input type="text" name="country" value="{{ $property->country ?? old('country') }}" required
                    class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="USA">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">City *</label>
                <input type="text" name="city" value="{{ $property->city ?? old('city') }}" required
                    class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Malibu">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Address</label>
                <input type="text" name="address" value="{{ $property->address ?? old('address') }}"
                    class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="123 Ocean Drive">
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Description *</label>
            <textarea name="description" rows="5" required
                class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Describe your property...">{{ $property->description ?? old('description') }}</textarea>
        </div>
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Features (comma separated)</label>
            <input type="text" name="features" value="{{ $property->features ?? old('features') }}"
                class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Pool, Garage, Garden, Security">
        </div>
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Images</label>
            <input type="file" name="images[]" multiple accept="image/*"
                class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700">
            <p class="text-xs text-gray-500 mt-2">You can select multiple images</p>
        </div>
        
        <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
            <a href="{{ route('agent.properties.index') }}" class="py-3 px-6 border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all">
                Cancel
            </a>
            <button type="submit" class="py-3 px-6 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all">
                {{ $isEdit ? 'Update Property' : 'Create Property' }}
            </button>
        </div>
    </form>
</div>
@endsection