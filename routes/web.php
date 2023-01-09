<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('welcome');

Auth::routes(['login' => true, 'register' => false, 'verify' => true, 'logout' => false]);

Route::group(['middleware' => ['auth','verified']], function () {
    // Authenticate & Verified Routes Will be Here
    Route::get('/home', [HomeController::class, 'home'])->name('home');
});
Route::any('logout', [LoginController::class, 'logout'])->name('logout');
