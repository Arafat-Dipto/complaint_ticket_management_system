<?php

use App\Http\Controllers\Api\ComplaintController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/complaints', [ComplaintController::class, 'index']);

    Route::post('/complaints', [ComplaintController::class, 'store']);

    Route::get('/complaints/{id}', [ComplaintController::class, 'show']);

    Route::post('/complaints/{id}/status', [ComplaintController::class, 'updateStatus']);

    Route::post('/complaints/{id}/comment', [ComplaintController::class, 'addComment']);

});
