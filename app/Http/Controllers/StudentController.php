<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Company;
use App\Models\Journal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        $companies = Company::orderBy('id','asc')->paginate(10);
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
            'profilePicture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'position',
            'supervisor',
        ]);

        // Get the student signature file
        if ($profilePicture = $request->file('profilePicture')) {
            $profilePicturePath = 'profilePicture/';
            $profilePictureImage = date('YmdHis') . "." . $profilePicture->getClientOriginalExtension();
            $profilePicture->move($profilePicturePath, $profilePictureImage);
            $input['profilePicture'] = $profilePicturePath.$profilePictureImage; // Full path
        }

        $newPositions = explode(',', $request->input('position'));

        // Check if a position is selected (not empty) before merging
        if ($request->filled('position')) {
            // Merge the new positions with the existing positions
            $positions = array_merge($student->position, $newPositions);
        } else {
            $positions = $student->position;
        }

        //Create an update for User table profilePicture
        $user->update([
            'profilePicture'=>  $input['profilePicture'],
        ]);

        // Updating Company
        $student->update([
            'position' => $positions,
            'supervisor' => $request->input('supervisor'),
        ]);

        return redirect()->route('student_profile')->with('success', 'Company has been updated successfully.');
    }

}
