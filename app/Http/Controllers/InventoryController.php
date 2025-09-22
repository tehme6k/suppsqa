<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $inventories = Inventory::query()
            ->when($request->search, function ($query, $search) {
                $query->where('lot_number', 'like', "%{$search}%")->orWhereHas('product', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                });
            })
            ->when($request->field && $request->direction, function ($query) use ($request) {
                $query->orderBy($request->field, $request->direction);
            })
            ->paginate(10)
            ->withQueryString()
            ->through(fn($inventory) => [
                'id' => $inventory->id,
                'product_id' => $inventory->product_id,
                'vendor_id' => $inventory->vendor_id,
                'product_name' => $inventory->product->name,
                'vendor_name' => $inventory->vendor->name,
                'lot_number' => $inventory->lot_number,
                'adjustment_type' => $inventory->adjustment_type,
                'quantity' => $inventory->quantity,
                'facility_location' => $inventory->facility_location,
                'uom' => $inventory->uom,
                'expiration_date' => $inventory->expiration_date,
                'product_name' => $inventory->product->name,
                'created_at' => $inventory->created_at
            ]);


        // dd($inventories);

        return Inertia::render('Inventory/Index', [
            'inventories' => $inventories,
            'filters' => $request->only('search', 'field', 'direction'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        $vendors = Vendor::orderBy('name', 'asc')->get();
        $products = Product::orderBy('name', 'asc')->get();
        return Inertia::render('Inventory/Create', [
            'vendors' => $vendors,
            'products' => $products,
            'user' => $user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInventoryRequest $request)
    {
        // dd($request->validated());

        $inv = new Inventory();

        $create = $inv->create([
            'product_id' => $request->product_id,
            'vendor_id' => $request->vendor_id,
            'lot_number' => $request->lot_number,
            'adjustment_type' => $request->adjustment_type,
            'quantity' => $request->quantity,
            'uom' => $request->uom,
            'expiration_date' => $request->expiration_date,
            'facility_location' => $request->facility_location,
            'quarantine_user' => $request->quarantine_user,
        ]);

        if ($create) {
            $qty = $request->quantity;
            $uom = $request->uom;

            if ($uom == 'g') {
                $qty = $request->quantity / 1000;
            } elseif ($uom == 'lb') {
                $qty = $request->quantity * 0.453592;
            }

            $product = Product::find($request->product_id);
            $product->quantity = $product->quantity + $qty;
            $product->save();
        }

        return to_route('inventories.index')->with('success', 'Inventory created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        // $inventory->load('product', 'vendor', 'user');

        // $inventory->append('formatted_created_at', 'formatted_expiration_date', 'where_location_is_quarantine');

        // dd($inventory);

        $quarantineQty = Inventory::query()
            ->where('product_id', $inventory->product_id)
            ->where('facility_location', 'quarantine')
            ->where('lot_number', $inventory->lot_number)
            ->sum('quantity');

        $warehouseQty = Inventory::query()
            ->where('product_id', $inventory->product_id)
            ->where('facility_location', 'warehouse')
            ->where('lot_number', $inventory->lot_number)
            ->sum('quantity');

        $productionQty = Inventory::query()
            ->where('product_id', $inventory->product_id)
            ->where('facility_location', 'production')
            ->where('lot_number', $inventory->lot_number)
            ->sum('quantity');


        $quarantineByLot = Inventory::query()
            // ->select('product_id','lot_number')
            ->where('product_id', $inventory->product_id)
            ->where('facility_location', 'quarantine')
            ->selectRaw('SUM(quantity) as total_quantity_quarantine')
            ->groupBy('product_id', 'lot_number')
            ->orderBy('lot_number')
            ->get();

        $quarantineByLot->load('product');

        dd($quarantineByLot);

        return Inertia::render('Inventory/Index', [
            'inventoryByLot' => $inventoryByLot,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventoryRequest $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }

    public function approve(Request $request) 
    {
        $inventory = Inventory::find($request->id);
        // if(!$inventory){
        //     return to_route('inventories.index')->with('error', 'Inventory not found');
        // }

        $inventory->facility_location = 'warehouse';
        $inventory->save();

        return to_route('inventories.index')->with('success', 'Inventory approved successfully');
    }
}
