<?php

use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

Route::resource('inventories', InventoryController::class)->middleware(['auth', 'verified']);;