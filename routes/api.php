<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\TravelController;
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

Route::post('login', [AuthController::class, 'login']);

Route::get('travels/{travel}/tours', [TourController::class, 'index']);

Route::get('travels', [TravelController::class, 'index']);

Route::middleware(['auth:sanctum', 'role:editor'])->prefix('editor')->group(function () {

    Route::put('travels/{travel:id}', [TravelController::class, 'update']);

});

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {

    Route::post('travels', [TravelController::class, 'store']);

});
