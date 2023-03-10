<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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


Route::prefix('v1')->group(function () {
    Route::prefix('products')->name('product.')->group(function () {
        Route::post('', [ProductController::class, 'store'])->name('store');
        Route::post('/{id}', [ProductController::class, 'update'])->name('update');
        Route::get('', [ProductController::class, 'index'])->name('index');
    });
});