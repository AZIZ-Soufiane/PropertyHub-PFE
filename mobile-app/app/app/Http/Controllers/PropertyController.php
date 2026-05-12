<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Demo properties data - no authentication required
     */
    private function getDemoProperties()
    {
        return [
            [
                'id' => 1,
                'title' => 'Modern Luxury Villa',
                'location' => 'New York, USA',
                'price' => 850000,
                'bedrooms' => 4,
                'bathrooms' => 2,
                'area' => 3800,
                'status' => 'active',
                'agent' => ['id' => 1, 'name' => 'John Smith', 'phone' => '+1 (555) 123-4567', 'email' => 'john@propertyagent.com'],
            ],
            [
                'id' => 2,
                'title' => 'Contemporary Apartment',
                'location' => 'Los Angeles, USA',
                'price' => 450000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 2200,
                'status' => 'active',
                'agent' => ['id' => 2, 'name' => 'Sarah Johnson', 'phone' => '+1 (555) 234-5678', 'email' => 'sarah@propertyagent.com'],
            ],
            [
                'id' => 3,
                'title' => 'Cozy Family Home',
                'location' => 'Chicago, USA',
                'price' => 350000,
                'bedrooms' => 3,
                'bathrooms' => 1.5,
                'area' => 1800,
                'status' => 'sold',
                'agent' => ['id' => 3, 'name' => 'Michael Brown', 'phone' => '+1 (555) 345-6789', 'email' => 'michael@propertyagent.com'],
            ],
            [
                'id' => 4,
                'title' => 'Penthouse Downtown',
                'location' => 'Miami, USA',
                'price' => 1250000,
                'bedrooms' => 5,
                'bathrooms' => 3,
                'area' => 4500,
                'status' => 'active',
                'agent' => ['id' => 4, 'name' => 'Emily Davis', 'phone' => '+1 (555) 456-7890', 'email' => 'emily@propertyagent.com'],
            ],
            [
                'id' => 5,
                'title' => 'Beachfront Villa',
                'location' => 'San Diego, USA',
                'price' => 950000,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 4000,
                'status' => 'active',
                'agent' => ['id' => 5, 'name' => 'David Wilson', 'phone' => '+1 (555) 567-8901', 'email' => 'david@propertyagent.com'],
            ],
        ];
    }

    /**
     * Display all properties with search/filter
     */
    public function index(Request $request)
    {
        $properties = $this->getDemoProperties();
        $search = $request->get('search', '');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $status = $request->get('status', '');

        // Filter by search
        if ($search) {
            $properties = array_filter($properties, function ($p) use ($search) {
                return stripos($p['location'], $search) !== false || stripos($p['title'], $search) !== false;
            });
        }

        // Filter by price range
        if ($minPrice) {
            $properties = array_filter($properties, fn($p) => $p['price'] >= (int)$minPrice);
        }
        if ($maxPrice) {
            $properties = array_filter($properties, fn($p) => $p['price'] <= (int)$maxPrice);
        }

        // Filter by status
        if ($status) {
            $properties = array_filter($properties, fn($p) => $p['status'] === $status);
        }

        return view('properties.index', compact('properties', 'search', 'minPrice', 'maxPrice', 'status'));
    }

    /**
     * Display property details
     */
    public function show($id)
    {
        $properties = $this->getDemoProperties();
        $property = collect($properties)->firstWhere('id', (int)$id);

        if (!$property) {
            return redirect()->route('properties.index')->with('error', 'Property not found');
        }

        return view('properties.show', compact('property'));
    }

    /**
     * Browse properties by agent
     */
    public function byAgent($agentId)
    {
        $properties = $this->getDemoProperties();
        $agent = null;

        $properties = collect($properties)
            ->filter(fn($p) => $p['agent']['id'] === (int)$agentId)
            ->all();

        if (count($properties) > 0) {
            $agent = $properties[0]['agent'];
        }

        return view('properties.by-agent', compact('properties', 'agent'));
    }

    /**
     * Home page
     */
    public function home()
    {
        $featuredProperties = array_slice($this->getDemoProperties(), 0, 3);
        return view('welcome', compact('featuredProperties'));
    }

    /**
     * Search properties
     */
    public function search(Request $request)
    {
        return $this->index($request);
    }

    /**
     * Compare properties page
     */
    public function compare(Request $request)
    {
        $compareIds = session('compare', []);
        $properties = $this->getDemoProperties();
        
        $compareProperties = collect($properties)
            ->filter(fn($p) => in_array($p['id'], $compareIds))
            ->values()
            ->all();

        return view('properties.compare', compact('compareProperties'));
    }

    /**
     * Add property to compare
     */
    public function addToCompare(Request $request)
    {
        $id = $request->get('id');
        $compare = session('compare', []);
        
        if (!in_array($id, $compare) && count($compare) < 3) {
            $compare[] = $id;
            session(['compare' => $compare]);
        }
        
        return back()->with('success', 'Property added to compare');
    }

    /**
     * Remove property from compare
     */
    public function removeFromCompare($id)
    {
        $compare = session('compare', []);
        $compare = array_filter($compare, fn($i) => $i != $id);
        session(['compare' => array_values($compare)]);
        
        return back()->with('success', 'Property removed from compare');
    }

    /**
     * Clear compare list
     */
    public function clearCompare()
    {
        session(['compare' => []]);
        return back()->with('success', 'Compare list cleared');
    }
}

