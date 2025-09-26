<?php

use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

Route::resource('inventories', InventoryController::class)->middleware(['auth', 'verified']);

Route::post('inventories/approve/', [InventoryController::class, 'approve'])->middleware(['auth', 'verified'])->name('inventory.approve');

Route::get('inventories/{inventory}/adjust/', [InventoryController::class, 'adjust'])->middleware(['auth', 'verified'])->name('inventory.adjust');

Route::post('inventories/store-adjustment/', [InventoryController::class, 'storeAdjustment'])->middleware(['auth', 'verified'])->name('inventory.store-adjustment');