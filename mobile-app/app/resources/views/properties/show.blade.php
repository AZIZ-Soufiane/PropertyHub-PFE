@extends('layouts.app')

@section('title', 'Property Details - PropertyHub')

@section('content')
<!-- Gallery Section -->
<div class="relative h-64 bg-gradient-to-br from-primary-400 to-primary-500 flex items-center justify-center overflow-hidden">
    <svg class="w-32 h-32 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9"></path>
    </svg>
    <span class="absolute top-4 right-4 bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full">Sale</span>
    <button class="absolute top-4 left-4 p-2 bg-white rounded-lg hover:shadow-lg transition-smooth">
        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    <button class="absolute top-4 right-12 p-2 bg-white rounded-lg hover:shadow-lg transition-smooth" id="favorite-btn">
        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
    </button>
</div>

<!-- Property Header -->
<div class="px-4 py-6 bg-white border-b border-slate-100">
    <div class="flex items-start justify-between mb-3">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Modern Luxury Villa</h1>
            <p class="text-sm text-slate-600 flex items-center gap-1 mt-1">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                New York, New York, USA
            </p>
        </div>
    </div>
    <p class="text-3xl font-black text-primary-600">$850,000</p>
</div>

<!-- Key Features Grid -->
<div class="px-4 py-4 border-b border-slate-100">
    <div class="grid grid-cols-4 gap-2">
        <div class="text-center p-3 bg-slate-50 rounded-lg">
            <p class="text-xs text-slate-600 font-semibold mb-1">Rooms</p>
            <p class="text-xl font-black text-slate-900">4</p>
        </div>
        <div class="text-center p-3 bg-slate-50 rounded-lg">
            <p class="text-xs text-slate-600 font-semibold mb-1">Baths</p>
            <p class="text-xl font-black text-slate-900">2</p>
        </div>
        <div class="text-center p-3 bg-slate-50 rounded-lg">
            <p class="text-xs text-slate-600 font-semibold mb-1">Size</p>
            <p class="text-xl font-black text-slate-900">3.8K</p>
        </div>
        <div class="text-center p-3 bg-slate-50 rounded-lg">
            <p class="text-xs text-slate-600 font-semibold mb-1">Year</p>
            <p class="text-xl font-black text-slate-900">2021</p>
        </div>
    </div>
</div>

<!-- Description -->
<div class="px-4 py-6 border-b border-slate-100">
    <h2 class="text-lg font-bold text-slate-900 mb-3">Description</h2>
    <p class="text-sm text-slate-700 leading-relaxed">
        Welcome to this stunning modern luxury villa perfectly situated in one of New York's most desirable neighborhoods. This exquisite property features contemporary design, premium finishes, and exceptional amenities throughout.
    </p>
</div>

<!-- Amenities -->
<div class="px-4 py-6 border-b border-slate-100">
    <h2 class="text-lg font-bold text-slate-900 mb-4">Amenities</h2>
    <div class="grid grid-cols-2 gap-3">
        <div class="flex items-center gap-2 p-3 bg-primary-50 rounded-lg">
            <svg class="w-4 h-4 text-primary-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            <span class="text-xs font-semibold text-slate-900">Modern Kitchen</span>
        </div>
        <div class="flex items-center gap-2 p-3 bg-primary-50 rounded-lg">
            <svg class="w-4 h-4 text-primary-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            <span class="text-xs font-semibold text-slate-900">Spacious Living</span>
        </div>
        <div class="flex items-center gap-2 p-3 bg-primary-50 rounded-lg">
            <svg class="w-4 h-4 text-primary-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            <span class="text-xs font-semibold text-slate-900">Garden</span>
        </div>
        <div class="flex items-center gap-2 p-3 bg-primary-50 rounded-lg">
            <svg class="w-4 h-4 text-primary-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            <span class="text-xs font-semibold text-slate-900">Parking</span>
        </div>
        <div class="flex items-center gap-2 p-3 bg-primary-50 rounded-lg">
            <svg class="w-4 h-4 text-primary-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            <span class="text-xs font-semibold text-slate-900">Security</span>
        </div>
        <div class="flex items-center gap-2 p-3 bg-primary-50 rounded-lg">
            <svg class="w-4 h-4 text-primary-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            <span class="text-xs font-semibold text-slate-900">Pool</span>
        </div>
    </div>
</div>

<!-- Agent Card -->
<div class="px-4 py-6 border-b border-slate-100">
    <h2 class="text-lg font-bold text-slate-900 mb-4">Agent</h2>
    <div class="flex items-center gap-4 p-4 bg-primary-50 rounded-xl">
        <div class="w-16 h-16 bg-primary-600 rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
        </div>
        <div class="flex-1">
            <h3 class="font-bold text-slate-900 text-sm">John Smith</h3>
            <p class="text-xs text-slate-600">Senior Agent</p>
            <p class="text-xs font-semibold text-primary-600 mt-1">📞 +1 (555) 123-4567</p>
        </div>
    </div>
</div>

<!-- Actions -->
<div class="px-4 py-6 space-y-3 pb-12">
    <a href="{{ route('appointments.book', ['propertyId' => 1]) }}" class="w-full block text-center bg-primary-600 text-white font-semibold py-3 rounded-lg hover:bg-primary-700 transition-smooth">
        📅 Book Appointment
    </a>
    <a href="{{ route('properties.index') }}" class="w-full block text-center bg-slate-100 text-slate-900 font-semibold py-3 rounded-lg hover:bg-slate-200 transition-smooth">
        ← Back to Properties
    </a>
</div>

<script>
    document.getElementById('favorite-btn').addEventListener('click', function() {
        this.classList.toggle('text-primary-600');
        const svg = this.querySelector('svg');
        if (this.classList.contains('text-primary-600')) {
            svg.style.fill = '#3b65ad';
        } else {
            svg.style.fill = 'none';
        }
    });
</script>
@endsection
