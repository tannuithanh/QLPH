<?php

use App\Http\Controllers\Pages\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/manager_shedule', [ScheduleController::class, 'showManagerSchedule'])->middleware('auth')->name('showManagerSchedule');



Route::get('/Register_Schedule', [ScheduleController::class, 'showRegisterSchedule'])->middleware('auth')->name('showRegisterSchedule');
