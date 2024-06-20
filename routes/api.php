<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('orders', [\App\Http\Controllers\API\V1\OrderController::class, 'index'])->name('api.orders.index');
Route::get('recipe', [\App\Http\Controllers\API\V1\RecipeController::class, 'index'])->name('api.recipe.index');
Route::get('categories', [\App\Http\Controllers\API\V1\CategoryController::class, 'index'])->name('api.categories.index');
Route::get('items', [\App\Http\Controllers\API\V1\ItemController::class, 'index'])->name('api.items.index');
Route::get('purchases', [\App\Http\Controllers\API\V1\PurchaseController::class, 'getOptions'])->name('api.purchases.getOptions');
