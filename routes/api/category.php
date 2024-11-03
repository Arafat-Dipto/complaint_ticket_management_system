<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/categories', [CategoryController::class, 'getCategoryList']);
    Route::post('/categories', [CategoryController::class, 'categoryCreate']);
    Route::get('/category/show/{id}', [CategoryController::class, 'categoryDetails']);
    Route::post('/categories/{id}', [CategoryController::class, 'categoryUpdate']);
    Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory']);

});
