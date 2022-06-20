<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Models\Equipment;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('auth:web')->group(function () {


    Route::get('/equipments', [EquipmentController::class, 'index'])->name('equipment');
    Route::post('/equipments', [EquipmentController::class, 'store']);
    Route::delete('/equipments/{equipment}', [EquipmentController::class, 'disable']);
    Route::get('/equipments/{equipment}', [EquipmentController::class, 'show'])->name('findEquipment');
    Route::get('/equipments/category/{category_id}', [EquipmentController::class, 'filter'])->name('filterEquipment');



    Route::get('/users', function () {
        return view('pages.user ');
    })->name('user');

    Route::get('/info', function () {
        return view('pages.info ');
    })->name('info');
    Route::get('/', function () {
        return view('index');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});




Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('postLogin');