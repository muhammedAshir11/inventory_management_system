<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\InventoryReportController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/inventory/report', [InventoryReportController::class, 'index']);
    Route::post('/stock-movements', [StockMovementController::class, 'store']);
});
