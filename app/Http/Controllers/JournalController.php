<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\Student;
use App\Models\Journal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class JournalController extends Controller
{
    public function journalStudent()
    {
        $user = Auth::user();

        $journals = Journal::where('studentID', $user->schoolID)
            ->orderBy('journalNumber', 'asc')
            ->paginate(5);

        return view('student.journal', compact('journals'));
    }

    public function journalCoordinator()
    {
        $userMajor = auth()->user()->major;
        $studentIDs = Student::where('major', $userMajor)->pluck('studentID');

        $journals = Journal::whereIn('studentID', $studentIDs)
            ->orderBy('status', 'asc')
            ->orderBy('journalNumber', 'asc')
            ->get();

        return view('coordinator.student_journal', compact('journals'));
    }



    public function createJournal()
    {
        return view('student.journal-create');
    }

    public function storeJournal(Request $request)
    {
        $request->validate([
            'journalNumber' => 'required',
            'reflection' => 'required',
            'hoursRendered' => 'required',
            'studentSignature' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'supervisorSignature' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'coverage_start_date' => 'required',
            'coverage_end_date' => 'required',
        ]);

        $user = Auth::user();

        // Get the student signature file
        if ($studentSignature = $request->file('studentSignature')) {
            $studentSignaturePath = 'studentSignature/';
            $studentSignatureImage = date('YmdHis') . "." . $studentSignature->getClientOriginalExtension();
            $studentSignature->move($studentSignaturePath, $studentSignatureImage);
            $input['studentSignature'] = $studentSignaturePath.$studentSignatureImage; // Full path
        }

        // Get the supervisor signature file
        if ($supervisorSignature = $request->file('supervisorSignature')) {
            $supervisorSignaturePath = 'supervisorSignature/';
            $supervisorSignatureImage = date('YmdHis') . "." . $supervisorSignature->getClientOriginalExtension();
            $supervisorSignature->move($supervisorSignaturePath, $supervisorSignatureImage);
            $input['supervisorSignature'] = $supervisorSignaturePath.$supervisorSignatureImage; // Full path
        }

        // Create the Journal record using the $input array
        Journal::create([
            'studentID' => $user->schoolID,
            'journalNumber' => $request->input('journalNumber'),
            'reflection' => $request->input('reflection'),
            'hoursRendered' => $request->input('hoursRendered'),
            'studentSignature' => $input['studentSignature'],
            'supervisorSignature' => $input['supervisorSignature'],
            'coverage_start_date' => $request->input('coverage_start_date'),
            'coverage_end_date' => $request->input('coverage_end_date'),
            'grade' => null,
            'comments' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('student_journal')->with('success', 'Journal has been updated successfully');
    }

    public function editJournal(Journal $journal)
    {
        return view('student.journal-edit',compact('journal'));
    }

    public function updateJournal(Request $request, $journalID)
    {
        // Find the corresponding Journal by ID
        $journal = Journal::findOrFail($journalID);

        $request->validate([
            'journalNumber' => 'required',
            'hoursRendered' => 'required',
            'studentSignature' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'supervisorSignature' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'coverage_start_date' => 'required',
            'coverage_end_date' => 'required',
        ]);

        // Store the uploaded signatures and get their file paths
        $studentSignaturePath = $request->file('studentSignature')->store('public/signatures');
        $supervisorSignaturePath = $request->file('supervisorSignature')->store('public/signatures');

        // Update the Journal entry
        $journal->update([
            'coverage_start_date' => $request->input('coverage_start_date'),
            'coverage_end_date' => $request->input('coverage_end_date'),
            'journalNumber' => $request->input('journalNumber'),
            'hoursRendered' => $request->input('hoursRendered'),
            'studentSignature' => $studentSignaturePath,
            'supervisorSignature' => $supervisorSignaturePath,
            'updated_at' => now(), // Update the 'updated_at' field
        ]);
    }

    public function studentJournalGrade(Journal $journal)
    {
        // Mark Journal as Seen
        // Create if-else statement: If the grade is not null, set to 3; if null, set to 2
        $status = !is_null($journal->grade) ? 3 : 2;

        $journal->update([
            'status' => $status,
        ]);

        return view('coordinator.student_journal-grade', compact('journal'));
    }

    public function gradeJournal(Request $request, Journal $journal, $journalID)
    {
        // Find the corresponding Journal by ID
        $journal = Journal::findOrFail($journalID);

        $request->validate([
            'grade',
            'comments',
            'updated_at' => now(),
        ]);

        $journal->update([
            'grade' => $request->input('grade'),
            'comments' => $request->input('comments'),
            'supervisorSignature' => $request->input('supervisorSignature'),
        ]);

        // If grade is not null, set status to 3
        if (!is_null($request->input('grade'))) {
            $journal->update([
                'status' => 3,
            ]);
        }

        return redirect()->route('coordinator_student-journal')->with('success', 'Journal has been graded');
    }

    public function markAsUnread($journalID)
    {
        // Find the corresponding Journal by ID
        $journal = Journal::findOrFail($journalID);

        // Update the status to 1 (Unread)
        $journal->update([
            'status' => 1,
        ]);

        return redirect()->back()->with('success', 'Journal marked as unread successfully');
    }

}
