<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\PropertyService;

class HomeController extends Controller
{
    public function __construct(
        private PropertyService $propertyService,
        private CategoryService $categoryService,
    ) {}

    public function index()
    {
        $featuredProperties = $this->propertyService->getFeaturedProperties(6);
        $categories = $this->categoryService->getActive();

        return view('frontend.home', compact('featuredProperties', 'categories'));
    }
}
