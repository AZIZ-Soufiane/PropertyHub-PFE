<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    public function index()
    {
        $categories = $this->categoryService->getAll();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = $this->categoryService->create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'category' => $category]);
        }

        return redirect()->route('admin.categories.index')->with('success', "Category \"{$category->name}\" created.");
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'is_active' => 'nullable|boolean',
        ]);

        $this->categoryService->update($category, $validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'category' => $category->fresh()]);
        }

        return redirect()->route('admin.categories.index')->with('success', "Category \"{$category->name}\" updated.");
    }

    public function destroy(Request $request, Category $category)
    {
        $this->categoryService->delete($category);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.categories.index')->with('success', "Category \"{$category->name}\" deleted.");
    }
}
