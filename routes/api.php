<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\DashboardController;
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
Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
    Route::middleware('auth:sanctum')->get('/dashboard', [DashboardController::class, 'index']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::prefix('v1')->group(function () {

    require __DIR__ . "/api/role.php";
    require __DIR__ . "/api/privilege.php";
    require __DIR__ . "/api/user.php";
    require __DIR__ . "/api/category.php";
    require __DIR__ . "/api/complaint.php";
    require __DIR__ . "/api/report.php";

});
