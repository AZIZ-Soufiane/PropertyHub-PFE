<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\PropertyService;

class HomeController extends Controller
{
    public function __construct(private PropertyService $propertyService) {}

    public function index()
    {
        $featuredProperties = $this->propertyService->getFeaturedProperties(6);

        return view('frontend.home', compact('featuredProperties'));
    }
}
