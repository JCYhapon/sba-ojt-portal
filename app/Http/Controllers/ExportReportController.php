<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Student;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\JournalGradesExport;
use Maatwebsite\Excel\Facades\Excel;


class ExportReportController extends Controller
{
    public function journalGrade()
    {
        $userMajor = auth()->user()->major;
        $users = User::where('major', $userMajor)->where('role', 3)->get();
        $studentIDs = $users->pluck('schoolID')->flatten()->toArray();

        $coordinatorSections = Student::where('major', $userMajor)
            ->distinct('section')
            ->pluck('section');

        $sortedStudents = Student::whereIn('studentID', $studentIDs)
            ->orderBy('lastName', 'asc')
            ->get();

        $highestJournalNumber = Journal::max('journalNumber');

        $highestJournalNumber = $highestJournalNumber ?? 0;

        return view('coordinator.download_grade', compact('users', 'coordinatorSections', 'sortedStudents', 'highestJournalNumber'));
    }

    public function exportJournalGrades(Request $request)
    {

        $request->validate([
            'section' => 'nullable|string',
        ]);
        if ($request->section === 'all' || !$request->section) {
            return Excel::download(new JournalGradesExport, 'journal_grades.xlsx');
        }

        return Excel::download(new JournalGradesExport($request->section), 'journal_grades_' . $request->section . '.xlsx');
    }
}
