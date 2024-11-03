<?php

use App\Http\Controllers\Api\PrivilegeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/privileges', [PrivilegeController::class, 'getPrivilegeList']);

});
