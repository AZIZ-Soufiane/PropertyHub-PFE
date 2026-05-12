@extends('layouts.app')

@section('title', $property['title'] . ' - PropertyHub')

@section('content')
<div class="pt-4">
    <!-- Image -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative h-72 lg:h-96 rounded-3xl overflow-hidden bg-gradient-to-br from-blue-400 to-blue-600 mb-6" x-data="{ current: 0 }">
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-32 h-32 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9"></path>
                </svg>
            </div>

            <!-- Favorite Button -->
            <button id="favorite-btn" class="absolute top-4 right-4 z-20 p-2.5 bg-white/90 backdrop-blur-sm rounded-full text-gray-400 hover:text-rose-500 shadow-sm transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Property Info -->
            <div class="w-full lg:w-2/3">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <span class="text-sm font-bold text-blue-600 uppercase tracking-widest">{{ $property['status'] }}</span>
                        <h1 class="text-3xl font-black text-gray-900 mt-2">{{ $property['title'] }}</h1>
                        <div class="flex items-center gap-2 text-gray-500 mt-2 text-sm">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            {{ $property['location'] }}
                        </div>
                    </div>
                    <span class="text-3xl font-black text-blue-600">${{ number_format($property['price']) }}</span>
                </div>

                <!-- Features -->
                <div class="bg-gray-50 rounded-2xl p-6 mb-6">
                    <div class="grid grid-cols-4 gap-4">
                        <div class="text-center">
                            <span class="block text-[10px] uppercase font-black text-gray-400 tracking-widest mb-1">Bedrooms</span>
                            <span class="text-xl font-black text-gray-900">{{ $property['bedrooms'] }}</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-[10px] uppercase font-black text-gray-400 tracking-widest mb-1">Bathrooms</span>
                            <span class="text-xl font-black text-gray-900">{{ $property['bathrooms'] }}</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-[10px] uppercase font-black text-gray-400 tracking-widest mb-1">Area</span>
                            <span class="text-xl font-black text-gray-900">{{ number_format($property['area']) }} sqft</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-[10px] uppercase font-black text-gray-400 tracking-widest mb-1">Status</span>
                            <span class="text-xl font-black {{ $property['status'] === 'active' ? 'text-emerald-600' : 'text-gray-600' }}">{{ ucfirst($property['status']) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-3">Description</h2>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        Welcome to this stunning {{ $property['title'] }} perfectly situated in {{ $property['location'] }}. 
                        This exquisite property features contemporary design, premium finishes, and exceptional amenities throughout.
                        With {{ $property['bedrooms'] }} bedrooms and {{ $property['bathrooms'] }} bathrooms spread across {{ number_format($property['area']) }} sqft,
                        this is the perfect home for those seeking luxury and comfort.
                    </p>
                </div>

                <!-- Features List -->
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Features & Amenities</h2>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach(['Modern Kitchen', 'Spacious Living', 'Garden', 'Parking', 'Security', 'Pool'] as $feature)
                            <div class="flex items-center gap-2 text-gray-600 text-sm">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ $feature }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Agent Info -->
                <div class="bg-gray-50 rounded-2xl p-6 mb-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Listed by</h2>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-xl font-bold text-blue-600">{{ substr($property['agent']['name'], 0, 1) }}</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $property['agent']['name'] }}</h3>
                            <p class="text-gray-500 text-sm">{{ $property['agent']['email'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Schedule a Visit</h3>
                    
                    <form action="{{ route('appointments.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="property_id" value="{{ $property['id'] }}">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Date</label>
                            <input type="date" name="date" required min="{{ date('Y-m-d') }}"
                                class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-600 focus:ring-blue-600">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Time</label>
                            <select name="time_slot" required class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm">
                                <option value="09:00">09:00 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="14:00">02:00 PM</option>
                                <option value="15:00">03:00 PM</option>
                                <option value="16:00">04:00 PM</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full py-3 px-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all">
                            Request Appointment
                        </button>
                    </form>

                    <hr class="my-6 border-gray-200">

                    <div class="space-y-3">
                        <a href="mailto:{{ $property['agent']['email'] }}?subject=Inquiry about {{ $property['title'] }}" 
                            class="flex items-center justify-center gap-2 py-3 px-4 border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Send Message
                        </a>
                        <a href="{{ route('compare.add') }}?id={{ $property['id'] }}" 
                            class="flex items-center justify-center gap-2 py-3 px-4 bg-gray-50 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition-all text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Compare
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.getElementById('favorite-btn')?.addEventListener('click', function() {
        this.classList.toggle('text-rose-500');
        const svg = this.querySelector('svg');
        if (this.classList.contains('text-rose-500')) {
            svg.style.fill = '#f43f5e';
        } else {
            svg.style.fill = 'none';
        }
    });
</script>
@endsection