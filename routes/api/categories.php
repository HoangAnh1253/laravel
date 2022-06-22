<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::patch('/categories/{category}', [CategoryController::class, 'update']);