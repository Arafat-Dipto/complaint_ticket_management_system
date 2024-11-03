<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'getUserList']);
    Route::post('/users', [UserController::class, 'userCreate']);
    Route::post('/users/{id}', [UserController::class, 'userUpdate']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUser']);

});
