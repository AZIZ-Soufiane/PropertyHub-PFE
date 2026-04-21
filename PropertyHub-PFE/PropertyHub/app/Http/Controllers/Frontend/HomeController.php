<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProperties = Property::with('images')
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('frontend.home', compact('featuredProperties'));
    }
}