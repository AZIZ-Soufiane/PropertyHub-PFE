<?php

namespace App\Http\Controllers\Admin;

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
        $properties = $this->propertyService->getAdminProperties($request->only(['status', 'search', 'sort']));
        $stats      = $this->propertyService->getPropertyStatistics();
        $agents     = $this->propertyService->getAssignableAgents();
        $statuses   = $this->propertyService->getAllStatuses();
        $categories = $this->categoryService->getActive();

        return view('admin.properties.index', compact('properties', 'stats', 'agents', 'statuses', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|string|max:50',
            'price'       => 'required|numeric|min:0',
            'area'        => 'nullable|numeric|min:0',
            'bedrooms'    => 'nullable|integer|min:0',
            'bathrooms'   => 'nullable|integer|min:0',
            'country'     => 'nullable|string|max:100',
            'city'        => 'nullable|string|max:100',
            'address'     => 'nullable|string|max:255',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'features'    => 'nullable|string',
            'status'      => 'required|string|in:pending,approved,rejected,sold,rented',
            'agent_id'    => 'required|exists:users,id',
            'images.*'    => 'nullable|image|max:5120',
        ]);

        $property = $this->propertyService->createProperty($validated);
        $this->propertyService->storeImages($property, $request->file('images', []));

        return redirect()->route('admin.properties.index')->with('success', 'Property created successfully.');
    }



    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|string|max:50',
            'price'       => 'required|numeric|min:0',
            'area'        => 'nullable|numeric|min:0',
            'bedrooms'    => 'nullable|integer|min:0',
            'bathrooms'   => 'nullable|integer|min:0',
            'country'     => 'nullable|string|max:100',
            'city'        => 'nullable|string|max:100',
            'address'     => 'nullable|string|max:255',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'features'    => 'nullable|string',
            'status'      => 'required|string|in:pending,approved,rejected,sold,rented',
            'agent_id'    => 'required|exists:users,id',
            'images.*'    => 'nullable|image|max:5120',
        ]);

        $this->propertyService->updateProperty($property->id, $validated);

        if ($request->has('delete_images')) {
            $fresh = $this->propertyService->getPropertyById($property->id);
            $this->propertyService->deleteImages($fresh, $request->input('delete_images'));
        }

        if ($request->hasFile('images')) {
            $fresh = $this->propertyService->getPropertyById($property->id);
            $this->propertyService->storeImages($fresh, $request->file('images'));
        }

        return redirect()->route('admin.properties.index')->with('success', 'Property updated successfully.');
    }

    public function approve(Request $request, Property $property)
    {
        $p = $this->propertyService->approveProperty($property->id, $request->input('note'));
        return back()->with('success', "Property \"{$p->title}\" approved.");
    }

    public function reject(Request $request, Property $property)
    {
        $p = $this->propertyService->rejectProperty($property->id, $request->input('note'));
        return back()->with('success', "Property \"{$p->title}\" rejected.");
    }

    public function sold(Request $request, Property $property)
    {
        $p = $this->propertyService->markAsSold($property->id, $request->input('note'));
        return back()->with('success', "Property \"{$p->title}\" marked as sold. \${$p->price} added to revenue.");
    }

    public function rented(Request $request, Property $property)
    {
        $p = $this->propertyService->markAsRented($property->id, $request->input('note'));
        return back()->with('success', "Property \"{$p->title}\" marked as rented. \${$p->price} added to revenue.");
    }

    public function destroy(Property $property)
    {
        $this->propertyService->deleteProperty($property->id);
        return redirect()->route('admin.properties.index')->with('success', 'Property deleted.');
    }
}
