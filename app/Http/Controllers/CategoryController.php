<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start with a base query
        $categoriesQuery = Category::query();

        // Conditionally apply a search filter if a search term is present
        $categoriesQuery->when($request->has('search'), function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->input('search')}%");
        });

        if ($request->filled('sort')) {
            $sortColumn = ltrim($request->sort, '-');
            $sortDirection = str_starts_with($request->sort, '-') ? 'desc' : 'asc';
            $categoriesQuery->orderBy($sortColumn, $sortDirection);
        }

        // Paginate the results and append the search query to pagination links
        $categories = $categoriesQuery->paginate(3)->withQueryString();

        return Inertia::render('Category/Index', [
            'categories' => $categories,
            'filters' => $request->only('search', 'sort'), // Pass the current search term to the frontend
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->all());

        return to_route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return Inertia::render('Category/Show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return Inertia::render('Category/Edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $products = Product::where('category_id', $category->id)->count();
        if ($products > 0) {
            return to_route('categories.edit', $category->id)->with('error', 'Failed to update - Products use this category');
        } else {
            $category->update($request->all());

            return to_route('categories.index')->with('success', 'Category updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        // if($category->products()->exists()){
        //     dd('cant delete');
        // }
        $products = Product::where('category_id', $category->id)->count();
        if ($products > 0) {
            return back()->with('error', 'Failed to delete - Products use this category');
        } else {
            $category->delete();

            return to_route('categories.index')->with('success', 'Category deleted successfully.');
        }
    }
}
