<?php

use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;

Route::resource('brands', BrandController::class)->middleware(['auth', 'verified']);;