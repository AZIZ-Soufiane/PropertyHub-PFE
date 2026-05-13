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
                'type' => 'villa',
                'location' => 'New York, USA',
                'price' => 850000,
                'bedrooms' => 4,
                'bathrooms' => 2,
                'area' => 3800,
                'status' => 'active',
                'agent' => ['id' => 1, 'name' => 'John Smith', 'phone' => '+1 (555) 123-4567', 'email' => 'john@propertyagent.com'],
                'images' => [
                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800',
                    'https://images.unsplash.com/photo-1600585154340-be6199f7d009?w=800',
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800',
                    'https://images.unsplash.com/photo-1600566753376-12c8ab7c5e5c?w=800',
                ],
            ],
            [
                'id' => 2,
                'title' => 'Contemporary Apartment',
                'type' => 'apartment',
                'location' => 'Los Angeles, USA',
                'price' => 450000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 2200,
                'status' => 'active',
                'agent' => ['id' => 2, 'name' => 'Sarah Johnson', 'phone' => '+1 (555) 234-5678', 'email' => 'sarah@propertyagent.com'],
                'images' => [
                    'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=800',
                    'https://images.unsplash.com/photo-1600573472550-8090b5e0745e?w=800',
                    'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800',
                ],
            ],
            [
                'id' => 3,
                'title' => 'Cozy Family Home',
                'type' => 'house',
                'location' => 'Chicago, USA',
                'price' => 350000,
                'bedrooms' => 3,
                'bathrooms' => 1.5,
                'area' => 1800,
                'status' => 'sold',
                'agent' => ['id' => 3, 'name' => 'Michael Brown', 'phone' => '+1 (555) 345-6789', 'email' => 'michael@propertyagent.com'],
                'images' => [
                    'https://images.unsplash.com/photo-1600585153490-76fb20a32601?w=800',
                    'https://images.unsplash.com/photo-1600573472591-ee6b68d14c68?w=800',
                    'https://images.unsplash.com/photo-1600585154084-4e5fe7c39198?w=800',
                ],
            ],
            [
                'id' => 4,
                'title' => 'Penthouse Downtown',
                'type' => 'penthouse',
                'location' => 'Miami, USA',
                'price' => 1250000,
                'bedrooms' => 5,
                'bathrooms' => 3,
                'area' => 4500,
                'status' => 'active',
                'agent' => ['id' => 4, 'name' => 'Emily Davis', 'phone' => '+1 (555) 456-7890', 'email' => 'emily@propertyagent.com'],
                'images' => [
                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800',
                    'https://images.unsplash.com/photo-1600607687644-c94bf900c7e7?w=800',
                    'https://images.unsplash.com/photo-1600566753086-00f18f6b0252?w=800',
                    'https://images.unsplash.com/photo-1600585154340-be6199f7d009?w=800',
                    'https://images.unsplash.com/photo-1600566753376-12c8ab7c5e5c?w=800',
                ],
            ],
            [
                'id' => 5,
                'title' => 'Beachfront Villa',
                'type' => 'villa',
                'location' => 'San Diego, USA',
                'price' => 950000,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 4000,
                'status' => 'active',
                'agent' => ['id' => 5, 'name' => 'David Wilson', 'phone' => '+1 (555) 567-8901', 'email' => 'david@propertyagent.com'],
                'images' => [
                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800',
                    'https://images.unsplash.com/photo-1600585154340-be6199f7d009?w=800',
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800',
                ],
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

