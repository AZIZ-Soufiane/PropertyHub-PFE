<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Appointment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'active_listings' => Property::where('agent_id', $user->id)->where('status', 'approved')->count(),
            'pending_viewings' => Appointment::whereHas('property', fn($q) => $q->where('agent_id', $user->id))
                ->where('status', 'pending')->whereDate('scheduled_at', today())->count(),
            'total_appointments' => Appointment::whereHas('property', fn($q) => $q->where('agent_id', $user->id))->count(),
            'unread_messages' => Message::where('receiver_id', $user->id)->whereNull('read_at')->count(),
            'new_this_week' => Property::where('agent_id', $user->id)->where('created_at', '>=', now()->subWeek())->count(),
        ];
        
        $upcomingAppointments = Appointment::with(['property', 'client'])
            ->whereHas('property', fn($q) => $q->where('agent_id', $user->id))
            ->whereDate('scheduled_at', '>=', today())
            ->orderBy('scheduled_at')
            ->take(3)
            ->get();
            
        $recentMessages = Message::with('sender')
            ->where('receiver_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $recentProperties = Property::with('images')
            ->where('agent_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return view('agent.dashboard', compact('stats', 'upcomingAppointments', 'recentMessages', 'recentProperties'));
    }

    public function index()
    {
        $properties = Property::with('images')
            ->where('agent_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('agent.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('agent.properties.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:villa,apartment,house,penthouse,land',
            'price' => 'required|numeric|min:0',
            'area' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'description' => 'required|string',
            'features' => 'nullable|string',
        ]);
        
        $validated['agent_id'] = Auth::id();
        $validated['status'] = 'pending';
        
        $property = Property::create($validated);
        
        if ($request->hasFile('images')) {
            $imageUrls = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                $imageUrls[] = '/storage/' . $path;
            }
            $property->images()->create(['image_urls' => $imageUrls]);
        }
        
        return redirect()->route('agent.properties.index')->with('success', 'Property created successfully');
    }

    public function edit(Property $property)
    {
        if ($property->agent_id !== Auth::id()) {
            abort(403);
        }
        return view('agent.properties.create', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        if ($property->agent_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:villa,apartment,house,penthouse,land',
            'price' => 'required|numeric|min:0',
            'area' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'description' => 'required|string',
            'features' => 'nullable|string',
        ]);
        
        $property->update($validated);
        
        if ($request->hasFile('images')) {
            $imageUrls = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                $imageUrls[] = '/storage/' . $path;
            }
            $property->images()->create(['image_urls' => $imageUrls]);
        }
        
        return redirect()->route('agent.properties.index')->with('success', 'Property updated successfully');
    }

    public function destroy(Property $property)
    {
        if ($property->agent_id !== Auth::id()) {
            abort(403);
        }
        
        $property->delete();
        
        return redirect()->route('agent.properties.index')->with('success', 'Property deleted');
    }
}