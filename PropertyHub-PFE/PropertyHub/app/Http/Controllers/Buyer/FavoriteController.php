<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with(['galleries', 'statusRelation'])->paginate(12);
        return view('buyer.favorites.index', compact('favorites'));
    }

    public function toggle(Property $property)
    {
        $user = Auth::user();

        if ($user->favorites()->where('property_id', $property->id)->exists()) {
            $user->favorites()->detach($property->id);
            $message = 'Removed from favorites.';
        } else {
            $user->favorites()->attach($property->id);
            $message = 'Added to favorites!';
        }

        return back()->with('success', $message);
    }
}
