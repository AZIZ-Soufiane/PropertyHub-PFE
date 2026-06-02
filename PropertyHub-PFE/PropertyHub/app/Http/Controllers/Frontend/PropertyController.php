<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with('images')->whereHas('statusRelation', fn($q) => $q->where('name', 'approved'));

        if ($request->has('location') && $request->location) {
            $query->where(function($q) use ($request) {
                $q->where('city', 'like', '%' . $request->location . '%')
                  ->orWhere('country', 'like', '%' . $request->location . '%')
                  ->orWhere('address', 'like', '%' . $request->location . '%');
            });
        }

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('bedrooms') && $request->bedrooms) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $properties = $query->paginate(12);

        return view('frontend.properties', compact('properties'));
    }

    public function show(Property $property)
    {
        $property->load(['images', 'agent']);

        return view('frontend.property-details', compact('property'));
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function compare(Request $request)
    {
        $compareIds = session('compare', []);

        if ($request->has('id') && $request->id) {
            $compareIds = array_unique(array_merge($compareIds, [(int)$request->id]));
            $compareIds = array_slice($compareIds, 0, 3);
            session(['compare' => $compareIds]);
        }

        $properties = Property::with('images')->whereIn('id', $compareIds)->get();

        return view('frontend.compare', compact('properties'));
    }

    public function compareClear()
    {
        session()->forget('compare');
        return redirect()->route('compare');
    }
}