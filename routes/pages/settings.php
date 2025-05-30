<?php

use App\Http\Controllers\Pages\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Mail\MeetingNotificationMail;
use Illuminate\Support\Facades\Mail;

Route::get('/users_manager', [SettingController::class, 'showUserManager'])->middleware('auth')->name('showUserManager');
Route::Post('/add_users', [SettingController::class, 'addUsers'])->middleware('auth')->name('addUsers');
Route::Post('/delete_users', [SettingController::class, 'deleteUsers'])->middleware('auth')->name('deleteUsers');
Route::Post('/edit_users', [SettingController::class, 'editUsers'])->middleware('auth')->name('editUsers');



Route::get('/department_manager', [SettingController::class, 'showDepartmentManager'])->middleware('auth')->name('showDepartmentManager');
Route::Post('/add_department', [SettingController::class, 'addDepartment'])->middleware('auth')->name('addDepartment');
Route::Post('/delelte_department', [SettingController::class, 'deleteDepartment'])->middleware('auth')->name('deleteDepartment');


Route::get('/meeting_Room_manager', [SettingController::class, 'showMeetingRoomManager'])->middleware('auth')->name('showMeetingRoomManager');
Route::Post('/add_meeting_room', [SettingController::class, 'addMeetingRoom'])->middleware('auth')->name('addMeetingRoom');
Route::Post('/delete_meeting_room', [SettingController::class, 'DelteMeetingRoom'])->middleware('auth')->name('DelteMeetingRoom');


Route::get('/role_manager', [SettingController::class, 'showRoleManager'])->middleware('auth')->name('showRoleManager');
Route::post('/add_all_role_manager', [SettingController::class, 'addAllRoleManager'])->middleware('auth')->name('addAllRoleManager');
Route::post('/delete_role_manager', [SettingController::class, 'deleteRoleManager'])->middleware('auth')->name('deleteRoleManager');
Route::post('/add_role_manager_single', [SettingController::class, 'addRoleManagerSingle'])->middleware('auth')->name('addRoleManagerSingle');

Route::get('/test-mail', function () {
    $meeting = \App\Models\MeetingHistory::latest()->first(); // hoặc fake
    Mail::to('tannguyen3502@gmail.com')
        ->send(new MeetingNotificationMail($meeting));

    return '✅ Mail đã gửi';
});