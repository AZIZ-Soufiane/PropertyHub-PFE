@extends('layouts.admin')

@section('title', 'Edit ' . $property->title)
@section('page-title', 'Edit property')
@section('page-subtitle', $property->title)

@section('content')
<div class="bg-white border border-slate-200 rounded-3xl overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-black text-slate-800">{{ $property->title }}</h2>
            <p class="text-xs text-slate-400 font-semibold">Created {{ $property->created_at->format('M d, Y') }}</p>
        </div>
        <a href="{{ route('admin.properties.index') }}"
           class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition-all">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Back to list
        </a>
    </div>

    <form action="{{ route('admin.properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
        @csrf
        @method('PUT')

        @if($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="sm:col-span-2">
                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Property Title</label>
                <input type="text" name="title" required value="{{ old('title', $property->title) }}"
                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
            </div>

            <div>
                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Price ($)</label>
                <input type="number" name="price" required step="0.01" value="{{ old('price', $property->price) }}"
                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
            </div>

            <div>
                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Type</label>
                <select name="type" required
                        class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                    @foreach(['villa','apartment','house','penthouse','land'] as $t)
                        <option value="{{ $t }}" @selected(old('type', $property->type) === $t)>{{ ucfirst($t) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Bedrooms</label>
                <input type="number" name="bedrooms" min="0" value="{{ old('bedrooms', $property->bedrooms) }}"
                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
            </div>

            <div>
                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Bathrooms</label>
                <input type="number" name="bathrooms" min="0" value="{{ old('bathrooms', $property->bathrooms) }}"
                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
            </div>

            <div>
                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Area (sq ft)</label>
                <input type="number" name="area" min="0" step="0.01" value="{{ old('area', $property->area) }}"
                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
            </div>

            <div>
                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">City</label>
                <input type="text" name="city" value="{{ old('city', $property->city) }}"
                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
            </div>

            <div>
                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Country</label>
                <input type="text" name="country" value="{{ old('country', $property->country) }}"
                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
            </div>

            <div class="sm:col-span-2">
                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Address</label>
                <input type="text" name="address" value="{{ old('address', $property->address) }}"
                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
            </div>

            <div>
                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Assigned Agent</label>
                <select name="agent_id" required
                        class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                    @foreach($agents as $agent)
                        <option value="{{ $agent->id }}" @selected(old('agent_id', $property->agent_id) == $agent->id)>{{ $agent->name }} ({{ $agent->email }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Status</label>
                <select name="status" required
                        class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                    @foreach(['pending','approved','rejected','sold','rented'] as $s)
                        <option value="{{ $s }}" @selected(old('status', $property->status) === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2">
                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Description</label>
                <textarea name="description" rows="4"
                          class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">{{ old('description', $property->description) }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Features (comma separated)</label>
                <input type="text" name="features" value="{{ old('features', $property->features) }}"
                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
            </div>

            <div class="sm:col-span-2">
                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Add Images</label>
                <input type="file" name="images[]" multiple accept="image/*"
                       class="block w-full text-sm text-slate-500 file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-500 hover:file:bg-primary-100">

                @if($property->images->count() > 0)
                    <div class="mt-4 grid grid-cols-4 sm:grid-cols-6 gap-2">
                        @foreach($property->images as $img)
                            @php $urls = is_array($img->image_urls) ? $img->image_urls : [$img->image_urls]; @endphp
                            @foreach($urls as $url)
                                <img src="{{ $url }}" class="w-full h-20 object-cover rounded-lg border border-slate-100">
                            @endforeach
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.properties.index') }}"
               class="py-3 px-6 text-sm font-bold rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition-all">
                Cancel
            </a>
            <button type="submit"
                    class="py-3 px-6 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl bg-primary-500 text-white hover:bg-primary-600 transition-all shadow-xl shadow-primary-500/20">
                Update Property
            </button>
        </div>
    </form>
</div>
@endsection
