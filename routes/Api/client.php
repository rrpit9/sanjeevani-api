<?php

namespace App\Http\Controllers\Api\v1\Client;

use Illuminate\Support\Facades\Route;

Route::get('dashboard',[ClientController::class, 'dashboard'])->name('dashboard');
Route::get('business',[ClientController::class, 'business'])->name('business');
Route::get('products',[ClientController::class, 'products'])->name('product');