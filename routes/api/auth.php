<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


//Route::middleware('auth:sanctum')->get('/getUser', [AuthController::class, 'user']);

Route::get('/logout', [AuthController::class, 'logout']);

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('authorize')->group(function () {
    Route::get('/getUser', [AuthController::class, 'user']);
    Route::post('/register', [AuthController::class, 'register']);
});