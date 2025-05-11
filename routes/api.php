<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\InventoryController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/inventory/report', [InventoryController::class, 'report']);
    // Route::post('/stock-movements', [InventoryController::class, 'storeMovement']);
});
