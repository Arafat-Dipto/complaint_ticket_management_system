<?php

use App\Http\Controllers\Api\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/roles', [RoleController::class, 'getRoleList']);
    Route::post('/roles', [RoleController::class, 'roleStoreOrUpdate']);
    Route::get('/roles/{id}', [RoleController::class, 'roleDetails']);
    Route::post('roles/{id}/privileges', [RoleController::class, 'assignAndRevokePrivilegesByRole']);
    Route::delete('/roles/{id}', [RoleController::class, 'deleteRole']);

});
