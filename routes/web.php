<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\UserController;
use App\Models\Equipment;
use Illuminate\Support\Facades\Auth;

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


Route::middleware(['auth:web', 'authorize'])->group(function () {


    Route::get('/equipments/search', [EquipmentController::class, 'search']);
    Route::get('/equipments', [EquipmentController::class, 'index'])->name('equipment');
    Route::post('/equipments', [EquipmentController::class, 'store']);
    Route::delete('/equipments/{equipment}', [EquipmentController::class, 'disable']);
    Route::get('/equipments/{equipment}', [EquipmentController::class, 'show'])->name('findEquipment');
    Route::get('/equipments/category/{category_id}', [EquipmentController::class, 'filter'])->name('filterEquipment');
    Route::get('/equipments/user/{user}', [EquipmentController::class, 'getEquipmentsOfUser'])->name('userEquipments');

    Route::get('/categories', [CategoryController::class, 'index'])->name('category');
    Route::post('/categories', [CategoryController::class, 'store'])->name('addCategory');
    Route::delete('/categories/{category}', [CategoryController::class, 'disable'])->name('disableCategory');

    Route::get('/users', [UserController::class, 'index'])->name('user');
    Route::post('/users', [UserController::class, 'store'])->name('addUser');
    Route::delete('/users/{user}', [UserController::class, 'disable'])->name('deleteUser');    
});

Route::get('/', [AuthController::class, 'index'])->name('home')->middleware('auth:web');


//Sidebar route

Route::get('/myEquipments',[EquipmentController::class,"getEquipmentsOfUser"]
)->name('myEquipments');

Route::get('/info', function () {
    $user= Auth::user();
    return view('pages.info ', ["user" => $user]);
})->name('info');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



//Login Route
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('postLogin');