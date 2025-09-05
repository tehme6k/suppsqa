<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start with a base query
        $productsQuery = Product::query();

        // Conditionally apply a search filter if a search term is present
        $productsQuery->when($request->has('search'), function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->input('search')}%");
        });

        // Paginate the results and append the search query to pagination links
        $products = $productsQuery->paginate(10)->withQueryString();
        $products->load('category', 'user');

        return Inertia::render('Product/Index', [
            'products' => $products,
            'filters' => $request->only('search'), // Pass the current search term to the frontend
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return Inertia::render('Product/Create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // dd($request->validated());
        $request->user()->products()->create($request->validated());

        return to_route('products.index')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category', 'user');
        $product->append('formatted_created_at')->toArray();
        return Inertia::render('Product/Show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return Inertia::render('Product/Edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return to_route('products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return to_route('products.index')->with('success', 'Product deleted successfully.');
    }
}
