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
            ->paginate(12);

        return view('student.journal', compact('journals'));
    }

    public function journalCoordinator()
    {
        $userMajor = auth()->user()->major;
        $studentIDs = Student::where('major', $userMajor)->pluck('studentID');

        $journals = Journal::whereIn('studentID', $studentIDs)
            ->orderBy('journalNumber', 'asc')
            ->get();

        return view('coordinator.student_journal', compact('journals'));
    }



    public function createJournal()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Retrieve the schoolID of the authenticated user
        $studentID = $user->schoolID;

        // Count the number of journal entries with the matching studentID
        $journalCount = Journal::where('studentID', $studentID)->count();

        if ($journalCount == 0) {
            $journalCount = 1;
        } else {
            $journalCount = $journalCount + 1;
        }
        // Log the count
        Log::info('Journal Count: ' . $journalCount);

        // Return the data to the view
        return view('student.journal-create', [
            'journalCount' => $journalCount
        ]);
    }

    public function storeJournal(Request $request)
    {
        $user = Auth::user();
        $studentID = $user->schoolID;
        $journalCount = Journal::where('studentID', $studentID)->count();

        if ($journalCount == 0) {
            $journalCount = 1;
        } else {
            $journalCount = $journalCount + 1;
        }

        $request->validate([
            'journalNumber',
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
            $input['studentSignature'] = $studentSignaturePath . $studentSignatureImage; // Full path
        }

        // Get the supervisor signature file
        if ($supervisorSignature = $request->file('supervisorSignature')) {
            $supervisorSignaturePath = 'supervisorSignature/';
            $supervisorSignatureImage = date('YmdHis') . "." . $supervisorSignature->getClientOriginalExtension();
            $supervisorSignature->move($supervisorSignaturePath, $supervisorSignatureImage);
            $input['supervisorSignature'] = $supervisorSignaturePath . $supervisorSignatureImage; // Full path
        }

        // Create the Journal record using the $input array
        Journal::create([
            'studentID' => $user->schoolID,
            'journalNumber' => $journalCount,
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
        return view('student.journal-edit', compact('journal'));
    }

    public function updateJournal(Request $request, $journalID)
    {
        // Find the corresponding Journal by ID
        $journal = Journal::findOrFail($journalID);

        $request->validate([
            'hoursRendered' => 'required',
            'coverage_start_date' => 'required',
            'coverage_end_date' => 'required',
            'reflection' => 'required',
        ]);

        // Update the Journal entry
        $journal->update([
            'reflection' => $request->input('reflection'),
            'coverage_start_date' => $request->input('coverage_start_date'),
            'coverage_end_date' => $request->input('coverage_end_date'),
            'hoursRendered' => $request->input('hoursRendered'),
            'updated_at' => now(), // Update the 'updated_at' field
        ]);

        return redirect()->route('student_journal')->with('success', 'Journal has been updated successfully');
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
        ]);

        $journal->update([
            'grade' => $request->input('grade'),
            'comments' => $request->input('comments'),
            'updated_at' => now(),
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
