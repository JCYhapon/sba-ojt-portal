<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Company;
use App\Models\Journal;
use App\Models\HistoryLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class HistoryLogController extends Controller
{
    public function logDisplay()
    {
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        HistoryLog::where('created_at', '<', $sixMonthsAgo)->delete();

        $historyLogs = HistoryLog::latest()->paginate(12);

        return view('admin.activity_log', compact('historyLogs'));
    }

    public function logCreate($userId, $role, $activity)
    {
        $historyLog = HistoryLog::create([
            'userID' => $userId,
            'role' => $role,
            'activity' => $activity,
        ]);
    }
}
