<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Services\AgentDashboardService;
use App\Services\PropertyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function __construct(
        private PropertyService $propertyService,
        private AgentDashboardService $dashboardService,
    ) {}

    public function dashboard()
    {
        $data = $this->dashboardService->getDashboardData(Auth::id());
        return view('agent.dashboard', $data);
    }

    public function index()
    {
        $properties = $this->propertyService->getAgentProperties(Auth::id());
        return view('agent.properties.index', compact('properties'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|in:villa,apartment,house,penthouse,land',
            'price'       => 'required|numeric|min:0',
            'area'        => 'required|numeric|min:0',
            'bedrooms'    => 'required|integer|min:0',
            'bathrooms'   => 'required|integer|min:0',
            'country'     => 'required|string|max:100',
            'city'        => 'required|string|max:100',
            'address'     => 'nullable|string|max:255',
            'description' => 'required|string',
            'features'    => 'nullable|string',
        ]);

        $validated['agent_id'] = Auth::id();
        $validated['status']   = 'pending';

        $property = $this->propertyService->createProperty($validated);
        $this->propertyService->storeImages($property, $request->file('images', []));

        return redirect()->route('agent.properties.index')->with('success', 'Property created successfully');
    }



    public function update(Request $request, int $propertyId)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|in:villa,apartment,house,penthouse,land',
            'price'       => 'required|numeric|min:0',
            'area'        => 'required|numeric|min:0',
            'bedrooms'    => 'required|integer|min:0',
            'bathrooms'   => 'required|integer|min:0',
            'country'     => 'required|string|max:100',
            'city'        => 'required|string|max:100',
            'address'     => 'nullable|string|max:255',
            'description' => 'required|string',
            'features'    => 'nullable|string',
        ]);

        $validated['status'] = 'pending';
        $validated['admin_note'] = null;

        $this->propertyService->updateProperty($propertyId, $validated);

        if ($request->has('delete_images')) {
            $fresh = $this->propertyService->getAgentProperty($propertyId, Auth::id());
            $this->propertyService->deleteImages($fresh, $request->input('delete_images'));
        }

        if ($request->hasFile('images')) {
            $fresh = $this->propertyService->getAgentProperty($propertyId, Auth::id());
            $this->propertyService->storeImages($fresh, $request->file('images'));
        }

        return redirect()->route('agent.properties.index')->with('success', 'Property updated successfully');
    }

    public function destroy(int $propertyId)
    {
        $this->propertyService->getAgentProperty($propertyId, Auth::id());
        $this->propertyService->deleteProperty($propertyId);

        return redirect()->route('agent.properties.index')->with('success', 'Property deleted');
    }
}
