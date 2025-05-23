<?php

use App\Http\Controllers\Pages\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->middleware('auth')->name('showDashboard');
