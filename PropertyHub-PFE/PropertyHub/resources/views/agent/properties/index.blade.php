@extends('layouts.agent')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">My Properties</h1>
        <p class="text-sm text-gray-500 mt-1">Manage your property listings</p>
    </div>
    <a href="{{ route('agent.properties.create') }}" 
       class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path d="M12 4v16m8-8H4" />
        </svg>
        Add New Listing
    </a>
</div>

<!-- Properties Table -->
<div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-3xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50/60">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Property</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Type</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Price</th>
                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($properties as $property)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <img class="w-10 h-10 rounded-xl object-cover" 
                                     src="{{ $property->images->first()?->first_url ?? 'https://via.placeholder.com/80' }}" alt="{{ $property->title }}">
                                <div>
                                    <p class="text-sm font-bold text-gray-800">{{ $property->title }}</p>
                                    <p class="text-xs text-gray-400 font-medium">{{ $property->city }}, {{ $property->country }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ ucfirst($property->type) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="py-1 px-3 inline-flex items-center gap-1 rounded-full text-[10px] font-bold 
                                {{ $property->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($property->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-700') }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $property->status === 'approved' ? 'bg-emerald-500' : ($property->status === 'pending' ? 'bg-amber-500' : 'bg-gray-500') }}"></span>
                                {{ ucfirst($property->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">${{ number_format($property->price) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('properties.show', $property) }}" 
                                   class="w-8 h-8 inline-flex justify-center items-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>
                                <a href="{{ route('agent.properties.edit', $property) }}" 
                                   class="w-8 h-8 inline-flex justify-center items-center text-gray-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </a>
                                <form action="{{ route('agent.properties.destroy', $property) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                        class="w-8 h-8 inline-flex justify-center items-center text-gray-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <p class="mb-4">No properties yet. Add your first listing!</p>
                            <a href="{{ route('agent.properties.create') }}" class="text-blue-600 hover:underline">Create Property</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($properties->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $properties->links() }}
        </div>
    @endif
</div>
@endsection