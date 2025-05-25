<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function showManagerSchedule(){
        return view('Pages.meeting.managerMeetingSchedule');
    }

    public function showRegisterSchedule(){
        return view('Pages.meeting.registerMeetingSchedule');
    }
}
