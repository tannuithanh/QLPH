<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/Dashboard', [DashboardController::class, 'index']);
Route::get('/', [DashboardController::class, 'loginView']);