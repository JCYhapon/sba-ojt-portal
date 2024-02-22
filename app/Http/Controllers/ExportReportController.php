<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Student;
use App\Models\Journal;
use Illuminate\Support\Facades\Auth;
use App\Exports\JournalGradesExport;
use Maatwebsite\Excel\Facades\Excel;


class ExportReportController extends Controller
{
    public function journalGrade()
    {
        $userMajor = auth()->user()->major;
        $users = User::where('major', $userMajor)->where('role', 3)->get();

        return view('coordinator.profile', ['users' => $users]);
    }

    public function exportJournalGrades()
    {
        return Excel::download(new JournalGradesExport, 'journal_grades.xlsx');
    }
}
