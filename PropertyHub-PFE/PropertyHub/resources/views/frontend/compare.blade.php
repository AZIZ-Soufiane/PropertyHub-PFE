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
            <a class="font-semibold text-gray-600 hover:text-blue-600 transition-colors" href="{{ route('properties.index') }}">Properties</a>
            <a class="font-bold text-blue-600" href="{{ route('compare') }}">Compare</a>
            @auth
                <a class="py-2 px-4 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 transition-all" href="{{ route('dashboard') }}">Dashboard</a>
            @else
                <a class="py-2 px-4 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-black transition-all" href="{{ route('login') }}">Log in</a>
            @endauth
        </div>
    </nav>
</header>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-black text-gray-900 mb-4">Compare Properties</h1>
        <p class="text-gray-500">Select up to 3 properties to compare side by side</p>
    </div>

    @if(session('compare') && count(session('compare')) > 0)
        <div class="overflow-x-auto">
            <table class="w-full bg-white rounded-2xl shadow-sm overflow-hidden">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left p-4 font-bold text-gray-500 uppercase text-sm">Property</th>
                        @foreach(session('compare') as $id)
                            @php $p = $properties->find($id); if($p): @endphp
                                <th class="p-4 text-center">
                                    <img src="{{ $p->images->first()?->first_url ?? 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=400' }}" alt="{{ $p->title }}" class="w-full h-32 object-cover rounded-xl mb-2">
                                    <a href="{{ route('properties.show', $p) }}" class="text-blue-600 font-bold hover:underline">{{ $p->title }}</a>
                                </th>
                            @php endif; @endphp
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100">
                        <td class="p-4 font-bold text-gray-500">Price</td>
                        @foreach(session('compare') as $id)
                            @php $p = $properties->find($id); if($p): @endphp
                                <td class="p-4 text-center text-2xl font-black text-blue-600">${{ number_format($p->price) }}</td>
                            @php endif; @endphp
                        @endforeach
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="p-4 font-bold text-gray-500">Location</td>
                        @foreach(session('compare') as $id)
                            @php $p = $properties->find($id); if($p): @endphp
                                <td class="p-4 text-center">{{ $p->city }}, {{ $p->country }}</td>
                            @php endif; @endphp
                        @endforeach
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="p-4 font-bold text-gray-500">Bedrooms</td>
                        @foreach(session('compare') as $id)
                            @php $p = $properties->find($id); if($p): @endphp
                                <td class="p-4 text-center text-xl font-bold">{{ $p->bedrooms }}</td>
                            @php endif; @endphp
                        @endforeach
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="p-4 font-bold text-gray-500">Bathrooms</td>
                        @foreach(session('compare') as $id)
                            @php $p = $properties->find($id); if($p): @endphp
                                <td class="p-4 text-center text-xl font-bold">{{ $p->bathrooms }}</td>
                            @php endif; @endphp
                        @endforeach
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="p-4 font-bold text-gray-500">Area</td>
                        @foreach(session('compare') as $id)
                            @php $p = $properties->find($id); if($p): @endphp
                                <td class="p-4 text-center text-xl font-bold">{{ number_format($p->area) }} sqft</td>
                            @php endif; @endphp
                        @endforeach
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="p-4 font-bold text-gray-500">Type</td>
                        @foreach(session('compare') as $id)
                            @php $p = $properties->find($id); if($p): @endphp
                                <td class="p-4 text-center"><span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm font-bold">{{ $p->type }}</span></td>
                            @php endif; @endphp
                        @endforeach
                    </tr>
                    <tr>
                        <td class="p-4 font-bold text-gray-500">Actions</td>
                        @foreach(session('compare') as $id)
                            @php $p = $properties->find($id); if($p): @endphp
                                <td class="p-4 text-center">
                                    <a href="{{ route('properties.show', $p) }}" class="text-blue-600 hover:underline text-sm">View Details</a>
                                </td>
                            @php endif; @endphp
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-6 text-center">
            <a href="{{ route('compare.clear') }}" class="text-gray-500 hover:text-gray-700">Clear comparison</a>
        </div>
    @else
        <div class="text-center py-20 bg-gray-50 rounded-2xl">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <h3 class="text-xl font-bold text-gray-700 mb-2">No properties to compare</h3>
            <p class="text-gray-500 mb-6">Browse our listings and add properties to compare</p>
            <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-2 py-3 px-6 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all">
Browse Properties
            </a>
        </div>
    @endif
</main>
@include('frontend.partials.footer')
@endsection