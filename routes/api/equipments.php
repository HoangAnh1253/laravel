<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;


Route::middleware('authorize')->group(function () {
});
Route::patch('equipments/{equipment}', [EquipmentController::class, 'update']);
Route::post('equipments', [EquipmentController::class, 'store']);
Route::delete('equipments/{equipment}/force', [EquipmentController::class, 'destroy']);
Route::delete('equipments/{equipment}', [EquipmentController::class, 'disable']);
Route::get('equipments/{equipment}', [EquipmentController::class, 'show']);

Route::get('equipments', [EquipmentController::class, 'index']);
Route::get('equipments/{equipment}/user', [EquipmentController::class, 'getUser']);


//Route::resource('equipments', EquipmentController::class);