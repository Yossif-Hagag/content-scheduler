<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PlatformController;
use App\Http\Controllers\Api\SettingsController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('posts', PostController::class);
    Route::get('platforms', [PlatformController::class, 'index']);
    Route::post('platforms/toggle', [PlatformController::class, 'toggleUserPlatform']);

    Route::post('/user/platform/toggle', [SettingsController::class, 'toggleActivePlatform']);
});
