<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Sanctum-protected API routes for mobile hardware bridges
Route::middleware(['auth:sanctum'])->group(function () {
    // Camera bridge
    Route::post('/hardware/camera/upload', [\App\Http\Controllers\Api\HardwareBridgeController::class, 'uploadCamera'])->name('api.hardware.camera.upload');
    // Bluetooth bridge
    Route::post('/hardware/bluetooth/check-in', [\App\Http\Controllers\Api\HardwareBridgeController::class, 'bluetoothCheckIn'])->name('api.hardware.bluetooth.checkin');
    // GPS bridge
    Route::post('/hardware/gps/location', [\App\Http\Controllers\Api\HardwareBridgeController::class, 'gpsLocation'])->name('api.hardware.gps.location');
    // Example: Get user profile for mobile
    Route::get('/user/profile', [\App\Http\Controllers\Api\UserController::class, 'profile'])->name('api.user.profile');
});
