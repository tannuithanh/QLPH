<?php

use App\Http\Controllers\Pages\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/manager_shedule', [ScheduleController::class, 'showManagerSchedule'])->middleware('auth')->name('showManagerSchedule');



Route::get('/Register_Schedule', [ScheduleController::class, 'showRegisterSchedule'])->middleware('auth')->name('showRegisterSchedule');
Route::post('/Handle_Register_Schedule', [ScheduleController::class, 'handleRegisterSchedule'])->middleware('auth')->name('handleRegisterSchedule');

Route::get('/edit_Schedule/{id}', [ScheduleController::class, 'showEditSchedule'])->middleware('auth')->name('showEditSchedule');
Route::post('/Handle_edit_Schedule', [ScheduleController::class, 'handleEditSchedule'])->middleware('auth')->name('handleEditSchedule');
Route::post('/delete_Schedule', [ScheduleController::class, 'deleteSchedule'])->middleware('auth')->name('deleteSchedule');
Route::post('/search_Schedule', [ScheduleController::class, 'searchSchedule'])->middleware('auth')->name('searchSchedule');