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

        $accountingSections = Student::where('major', 'Accounting')
            ->distinct('section')
            ->pluck('section');

        $managementSections = Student::where('major', 'Management')
            ->distinct('section')
            ->pluck('section');

        return view('coordinator.profile', compact('users', 'accountingSections', 'managementSections'));
    }

    public function exportJournalGrades(Request $request)
    {
        // Validate the section if provided
        $request->validate([
            'section' => 'nullable|string',
        ]);

        // You can access the selected section using $request->section
        // Pass this section to your export if needed

        // If no specific section is selected, export all grades
        if ($request->section === 'all' || !$request->section) {
            return Excel::download(new JournalGradesExport, 'journal_grades.xlsx');
        }

        // Otherwise, handle exporting for the selected section
        // You may need to adjust this part based on your export logic
        return Excel::download(new JournalGradesExport($request->section), 'journal_grades_' . $request->section . '.xlsx');
    }
}
