<?php

use App\Http\Controllers\Api\RouteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// GET
Route::get('products', [RouteController::class, 'productList']);
Route::get('categories', [RouteController::class, 'categoryList']); // READ *
// Route::get('categories/{id}', [RouteController::class, 'categoryDetails']);
Route::get('delete/category/{id}', [RouteController::class, 'deleteCategory']); // DELETE



// POST
Route::post('create/category', [RouteController::class, 'createCategory']); // CREATE
Route::post('create/contact', [RouteController::class, 'createContact']);
Route::post('categories/details', [RouteController::class, 'categoryDetails']); // READ
Route::post('categories/update', [RouteController::class, 'updateCategory']);   // UPDATE
