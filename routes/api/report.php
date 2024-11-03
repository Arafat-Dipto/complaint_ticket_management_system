<?php

use App\Http\Controllers\Api\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reports/complaints_by_status', [ReportController::class, 'complaintsByStatusReport']);
    Route::get('/reports/priority', [ReportController::class, 'complaintsByPriority']);
    Route::get('/reports/average-resolution-time', [ReportController::class, 'averageResolutionTime']);
    Route::get('/reports/trend', [ReportController::class, 'complaintsTrend']);

});
