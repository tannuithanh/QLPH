<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\MeetingHistory;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $today = Carbon::today()->toDateString();

        $histories = MeetingHistory::with(['meetingRoom', 'decisionMaker'])
            ->where('date', $today)
            ->orderBy('start_time')
            ->get();

        return view('pages.dashboard', compact('histories'));
    }
}
