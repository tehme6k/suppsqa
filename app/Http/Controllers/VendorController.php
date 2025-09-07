<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vendors = Vendor::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($request->field && $request->direction, function ($query) use ($request) {
                $query->orderBy($request->field, $request->direction);
            })
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($vendor) => [
                'id' => $vendor->id,
                'name' => $vendor->name,
                'website' => $vendor->website,
                'email' => $vendor->email,
                'phone_number' => $vendor->phone_number,
                'contact_name' => $vendor->contact_name
            ]);

        return Inertia::render('Vendor/Index', [
            'vendors' => $vendors,
            'filters' => $request->only('search', 'field', 'direction'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Vendor/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVendorRequest $request)
    {
        Vendor::create($request->all());

        return to_route('vendors.index')->with('success', 'Vendor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        $vendor->append('formatted_created_at')->toArray();
        return Inertia::render('Vendor/Show', [
            'vendor' => $vendor
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        return Inertia::render('Vendor/Edit', [
            'vendor' => $vendor
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVendorRequest $request, Vendor $vendor)
    {
        $products = Product::where('vendor_id', $vendor->id)->count();
        if ($products > 0) {
            return to_route('vendors.edit', $vendor->id)->with('error', 'Failed to update - Products use this brand');
        } else {
            $vendor->update($request->all());

            return to_route('vendors.index')->with('success', 'Vendor updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        $products = Product::where('vendor_id', $vendor->id)->count();
        if ($products > 0) {
            return back()->with('error', 'Failed to delete - Products use this vendor');
        } else {
            $vendor->delete();

            return to_route('vendors.index')->with('success', 'vendor deleted successfully.');
        }
    }
}
