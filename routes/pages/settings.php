<?php

use App\Http\Controllers\Pages\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/users_manager', [SettingController::class, 'showUserManager'])->middleware('auth')->name('showUserManager');
Route::Post('/add_users', [SettingController::class, 'addUsers'])->middleware('auth')->name('addUsers');
Route::Post('/delete_users', [SettingController::class, 'deleteUsers'])->middleware('auth')->name('deleteUsers');
Route::Post('/edit_users', [SettingController::class, 'editUsers'])->middleware('auth')->name('editUsers');






Route::get('/department_manager', [SettingController::class, 'showDepartmentManager'])->middleware('auth')->name('showDepartmentManager');
Route::Post('/add_department', [SettingController::class, 'addDepartment'])->middleware('auth')->name('addDepartment');
Route::Post('/delelte_department', [SettingController::class, 'deleteDepartment'])->middleware('auth')->name('deleteDepartment');