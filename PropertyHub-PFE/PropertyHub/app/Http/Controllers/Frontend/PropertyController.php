<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Services\CategoryService;
use App\Services\PropertyService;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct(
        private PropertyService $propertyService,
        private CategoryService $categoryService,
    ) {}

    public function index(Request $request)
    {
        $properties = $this->propertyService->getPublicProperties($request->all(), 12);
        $categories = $this->categoryService->getActive();

        return view('frontend.properties', compact('properties', 'categories'));
    }

    public function show(Property $property)
    {
        $property = $this->propertyService->getPropertyById($property->id);

        return view('frontend.property-details', compact('property'));
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function compare(Request $request)
    {
        $compareIds = session('compare', []);

        if ($request->filled('id')) {
            $id = (int) $request->id;

            if ($request->boolean('remove')) {
                $compareIds = array_values(array_diff($compareIds, [$id]));
            } else {
                $compareIds = array_values(array_unique(array_merge($compareIds, [$id])));
                $compareIds = array_slice($compareIds, 0, 3);
            }

            session(['compare' => $compareIds]);
        }

        $properties = $this->propertyService->getPropertiesByIds($compareIds);

        return view('frontend.compare', compact('properties'));
    }

    public function compareClear()
    {
        session()->forget('compare');
        return redirect()->route('compare');
    }
}
