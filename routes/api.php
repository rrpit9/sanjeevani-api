<?php
namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login',[AuthenticationController::class,'login'])->name('api.login');

Route::group(['middleware'=> ['auth:api','verified:api'],'as'=>'api.'],function(){
    // Authenticated API Routes will appear here
    Route::get('user/profile',[AuthenticationController::class,'getUserProfile'])->name('user.info');
    Route::get('user/notification',[ApiController::class, 'notification'])->name('user.notification');
    
    Route::group(['prefix' => 'client','middleware' => 'authenticate.client','as'=>'client.'],function(){
        require 'Api/client.php';
    });

    // Logout API
    Route::any('/logout',[AuthenticationController::class,'logoutFromSingleDevice'])->name('logout');
    Route::any('/logout_from_all',[AuthenticationController::class,'logoutFromAllDevice'])->name('logout_all');
});

Route::get('category',[ApiController::class,'category'])->name('api.category');
