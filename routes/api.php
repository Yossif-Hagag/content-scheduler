<?php

use App\Http\Controllers\Api\AnalyticsController;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PlatformController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // user
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::match(['put', 'post'], '/profile', [AuthController::class, 'updateProfile']);

    // Posts
    Route::get('posts', [PostController::class, 'index']);
    Route::post('posts', [PostController::class, 'store']);
    Route::get('posts/{post}', [PostController::class, 'show']);
    Route::match(['put', 'post'], 'posts/{post}', [PostController::class, 'update']);
    Route::delete('posts/{post}', [PostController::class, 'destroy']);

    // Platforms
    Route::get('platforms', [PlatformController::class, 'index']);
    Route::get('user/active-platforms', [PlatformController::class, 'showActivePlatformsToUser']);
    Route::post('user/platform/toggle', [PlatformController::class, 'toggleActivePlatform']);

    // Activity Logs
    Route::get('/logs', function () {
        return ActivityLog::with('user')
            ->where('user_id', auth()->id())
            ->latest()->limit(100)->get();
    });

    // Analytics
    Route::get('/analytics/posts', [AnalyticsController::class, 'posts']);
});
