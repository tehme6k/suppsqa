<?php

use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::resource('vendors', VendorController::class)->middleware(['auth', 'verified']);;