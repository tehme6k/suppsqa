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
        $categories = Category::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($request->field && $request->direction, function ($query) use ($request) {
                $query->orderBy($request->field, $request->direction);
            })
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
            ]);

        return Inertia::render('Category/Index', [
            'categories' => $categories,
            'filters' => $request->only('search', 'field', 'direction'),
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
        $category->append('formatted_created_at')->toArray();
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
