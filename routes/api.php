<?php

use App\Http\Controllers\Api\{AuthController,BlogController};
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json([
        'message' => 'API is working succssfully !!!'
    ]);
});


// login
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    
    //auth routes
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutFromAllDevices']);
    
    //blogs routes
    Route::apiResource('blogs', BlogController::class);
    Route::post('/blogs/{blog}/toggle-like', [BlogController::class, 'toggleLike']);
});