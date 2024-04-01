<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\HomeController as HomeAdminController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/comments/{productID}', [CommentController::class , 'index']);
Route::post('/create/comment', [CommentController::class , 'store']);

Route::get('/category/{categoryID}', [ProductController::class , 'getProductInCategory']);
Route::get('/search/{productName}', [ProductController::class , 'getProductByName']);
Route::get('/variant/{variantID}/{materialID}/{sizeID}', [ProductController::class , 'getVariant']);

Route::get('/admin/dates', [HomeAdminController::class, 'dates'])->name('dates');
Route::get('/admin/filter_date', [HomeAdminController::class, 'filter_date'])->name('filter_date');
Route::get('/admin/chart30day', [HomeAdminController::class, 'chart30day'])->name('chart30day');