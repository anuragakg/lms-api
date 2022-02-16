<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductVerticalModelController;
use App\Http\Controllers\API\ProcductCategoryController;
use App\Http\Controllers\API\ProductSubcategoryController;
use App\Http\Controllers\API\ProcductFormController;

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

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
   
Route::middleware('auth:api')->group( function () {
    Route::resource('product_vertical', ProductVerticalModelController::class);
    Route::resource('product_category', ProcductCategoryController::class);
    Route::resource('product_subcategory', ProductSubcategoryController::class);
    Route::resource('product_form', ProcductFormController::class);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
