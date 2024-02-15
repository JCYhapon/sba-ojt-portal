<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Company;
use App\Models\Journal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    private function studentHiredCompany($students)
    {
        $hiredCompany = $students->hiredCompany;
        $companyIDs = json_decode($hiredCompany, true);

        return Student::whereIn('companyID', $companyIDs)->get();
    }

    public function journalRenderedHours()
    {
        // Get the schoolID of the authenticated user
        $userSchoolID = auth()->user()->schoolID;

        // Search for the Student with the specified schoolID
        $student = Student::where('studentID', $userSchoolID)->first();

        // Search for the Student with the Company
        $companies = Company::where('id', $student->hiredCompany)->first();

        // If a student is found, calculate the total rendered hours and remaining hours
        if ($student) {
            $totalRenderedHours = Journal::where('studentID', $student->id)->sum('hoursRendered');
            $neededHours = $student->neededHours;
            $remainingHours = $student->neededHours - $totalRenderedHours;
        } else {
            // Handle the case where no student is found with the given schoolID
            $totalRenderedHours = 0;
            $remainingHours = 0;
        }

        // Pass the variables directly to the view
        return view('student.profile', compact(
            'totalRenderedHours',
            'remainingHours',
            'neededHours',
            'companies'
        ));
    }

    public function displayCompany()
    {
        $companies = Company::orderBy('id', 'asc')->paginate(12);
        return view('student.company_list', compact('companies'));
    }

    public function displayMatchedCompany()
    {
        // Get the schoolID of the authenticated user
        $userSchoolID = auth()->user()->schoolID;
        // Search for the Student with the specified schoolID
        $students = Student::where('studentID', $userSchoolID)->first();

        return view('student.matched_company-list', compact('students'));
    }

    public function editProfile(Student $student)
    {
        return view('student.profile-edit', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        // Get the schoolID of the authenticated user
        $userSchoolID = auth()->user()->schoolID;
        $user = User::findOrFail($userSchoolID);

        // Search for the Student with the specified schoolID
        $student = Student::where('studentID', $userSchoolID)->first();

        $request->validate([
            'profilePicture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'positions' => 'array', // Ensure positions is provided and is an array
            'positions.*' => 'string',
            'supervisor',
            'hiredCompany',
            'workType',
        ]);

        // Initialize input variable
        $input = [];

        // Get the student signature file if it exists
        if ($request->hasFile('profilePicture')) {
            $profilePicture = $request->file('profilePicture');
            $profilePicturePath = 'profilePicture/';
            $profilePictureImage = date('YmdHis') . "." . $profilePicture->getClientOriginalExtension();
            $profilePicture->move($profilePicturePath, $profilePictureImage);
            $input['profilePicture'] = $profilePicturePath . $profilePictureImage; // Full path
        }

        // Check if a profile picture was uploaded before proceeding with related steps
        if (!empty($input['profilePicture'])) {
            // Updating User table profilePicture
            $user->update([
                'profilePicture' => $input['profilePicture'],
            ]);
        }

        $updatedPositions = $request->input('positions') ?? [];

        // Check if a hiredCompany is (not empty)
        if ($request->filled('hiredCompany')) {
            $hiredCompany =  $request->input('hiredCompany');
        } else {
            $hiredCompany = $student->hiredCompany;
        }

        // Check if a supervisor is (not empty)
        if ($request->filled('supervisor')) {
            $supervisor =  $request->input('supervisor');
        } else {
            $supervisor = $student->supervisor;
        }


        // Updating Company
        $student->update([
            'position' => $updatedPositions,
            'supervisor' => $supervisor,
            'workType' => $request->input('workType'),
            'hiredCompany' => $hiredCompany,
        ]);


        return redirect()->route('student_profile')->with('success', 'Student has been updated successfully.');
    }

    public function removePositions(Request $request)
    {
        // Get the schoolID of the authenticated user
        $userSchoolID = auth()->user()->schoolID;

        // Search for the Student with the specified schoolID
        $student = Student::where('studentID', $userSchoolID)->first();

        // Validate the request
        $request->validate([
            'positions' => 'array', // Ensure positions is provided and is an array
            'positions.*' => 'string', // Ensure each position is a string
        ]);

        // Get the updated positions from the request, using an empty array as fallback if position is null
        $updatedPositions = $request->input('positions') ?? [];

        // Update the student's positions
        $updateStudent = $student->update([
            'position' => $updatedPositions,
        ]);

        // Optionally, you can return a response to indicate success or failure
        return back()->with('success', 'Positions updated successfully');
    }

    public function addSupervisor(Request $request)
    {
        // Get the schoolID of the authenticated user
        $userSchoolID = auth()->user()->schoolID;

        // Search for the Student with the specified schoolID
        $student = Student::where('studentID', $userSchoolID)->first();

        // Validate the request
        $request->validate([
            'supervisor' => 'required',
        ]);

        // Update the student's positions
        $updateStudent = $student->update([
            'supervisor' => $request->input('supervisor'),
        ]);

        // Optionally, you can return a response to indicate success or failure
        return back()->with('success', 'Supervisor updated successfully');
    }
}
