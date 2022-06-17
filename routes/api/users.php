<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('users', [UserController::class, 'index']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::get('users/{user}/equipments', [UserController::class, 'getEquipments']);
Route::patch('users/{user}', [UserController::class, 'update']);
Route::post('users', [UserController::class, 'store']);
Route::delete('users/{user}/force', [UserController::class, 'destroy']);
Route::delete('users/{user}', [UserController::class, 'disable']);

//Route::resource('users', UserController::class);