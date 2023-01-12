<?php

namespace App\Http\Controllers\Api\v1\Client;

use Illuminate\Support\Facades\Route;

Route::get('dashboard',[ClientController::class, 'dashboard'])->name('dashboard');
Route::get('business',[ClientController::class, 'business'])->name('business');
Route::get('products',[ClientController::class, 'products'])->name('product');
Route::post('item/add_to_cart',[ClientController::class, 'addtoCart'])->name('item.add_to_cart');