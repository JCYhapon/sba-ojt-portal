<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\Student;
use App\Models\Journal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CoordinatorUserController extends Controller
{
    public function studentlist(Request $request)
    {
        $userMajor = auth()->user()->major;
        $usersQuery = User::where('major', $userMajor)->where('role', 3);

        if ($request->has('filter') && $request->filter === 'deployed') {
            $students = Student::whereIn('studentID', $usersQuery->pluck('id'))
                ->whereNotNull('hiredCompany')
                ->pluck('id');

            $usersQuery = User::whereIn('schoolID', $students)->paginate(12);
        } else if ($request->has('filter') && $request->filter === 'undeployed') {
            $students = Student::whereIn('studentID', $usersQuery->pluck('id'))
                ->whereNull('hiredCompany')
                ->pluck('id');

            $usersQuery = User::whereIn('schoolID', $students)->paginate(12);
        } else {
            $usersQuery = $usersQuery->paginate(12);
        }

        return view('coordinator.student_list', ['users' => $usersQuery]);
    }


    // Retrieve information for the hired students
    private function userStudentsInfo($user)
    {
        $schoolID = $user->schoolID;
        $studentIDs = json_decode($schoolID, true);

        return Student::whereIn('studentID', $studentIDs)->get();
    }

    public function create()
    {
        return view('coordinator.student_list-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'studentID' => 'required|min:8|max:8',
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'major' => 'required',
            'section' => 'required',
        ]);

        $lastName = ucfirst(strtolower($request->input('lastName')));
        $firstName = ucfirst(strtolower($request->input('firstName')));

        // Create user details first
        $user = User::create([
            'id' => $request->input('studentID'),
            'schoolID' => $request->input('studentID'),
            'name' => $lastName . ', ' . $firstName,
            'email' => $request->input('email'),
            'role' => 3,
            'major' => $request->input('major'),
            'password' => Hash::make($request->input('password')),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create student details using the user relationship
        $student = Student::create([
            'id' => $request->input('studentID'),
            'studentID' => $request->input('studentID'),
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $request->input('email'),
            'major' => $request->input('major'),
            'section' => $request->input('section'),
            'position' => [],
            'suggestedCompany' => [],
            'matchedCompany' => [], // Set to an empty array
            'hiredCompany' => null,  // Set to null
            'status' => 1,
            'jobTitle' => null,
            'neededHours' => 600,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect(route('coordinator_student-list'))->with('success', 'Student created successfully.');
    }


    public function edit(Student $students)
    {
        $companies = Company::all();

        return view('coordinator.student_list-edit', compact('students', 'companies'));
    }

    public function update(Student $students, Company $company, Request $request)
    {
        $students = Student::with(['user', 'hiredCompany'])->findOrFail($students->id);

        // Access the user related to the student
        $user = $students->user;

        $request->validate([
            'studentID',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'section' => 'required',
            'major' => 'required',
            'matchedCompanies' => 'array',
            'matchedCompanies.*' => 'exists:companies,id',
            'positions' => 'array',
            'positions.*' => 'string',
            'hiredCompany',
            'status' => 'required',
            'password',
        ]);

        if ($request->has('password') && $request->input('password') !== null) {
            $password = Hash::make($request->input('password'));
        } else {
            $password = $user->password;
        }

        $lastName = ucfirst(strtolower($request->input('lastName')));
        $firstName = ucfirst(strtolower($request->input('firstName')));

        // Update user details
        $user = $students->user;
        $updateUser = $user->update([
            'name' => $lastName . ', ' . $firstName,
            'email' => $request->input('email'),
            'major' => $request->input('major'),
            'password' => $password,
            'updated_at' => now(),
        ]);

        if ($students->hiredCompany !== null) {
            // Find the previous company
            $previousCompany = Company::find($students->hiredCompany);

            if ($previousCompany) {
                // Remove student from the previous company's hiredStudents
                $previousCompany->update([
                    'hiredStudents' => array_diff($previousCompany->hiredStudents, [$students->studentID]),
                ]);
            }
        }

        // Find the new company
        $newCompany = Company::find($request->input('hiredCompany'));
        $updatedMatchedCompany = $request->input('matchedCompanies') ?? [];
        $updatedPositions = $request->input('positions') ?? [];

        if ($newCompany) {
            // Add student to the new company's hiredStudents
            $newCompany->update([
                'hiredStudents' => array_unique(array_merge($newCompany->hiredStudents, [$students->studentID])),
            ]);
        }

        // Check if a hiredCompany is selected (not empty) before merging
        if ($request->filled('hiredCompany')) {
            if ($request->input('hiredCompany') == 0) {
                $hiredCompany =  null;
            }
        } else {
            // If not filled, use the previous hiredCompany
            $hiredCompany = $students->hiredCompany;
        }



        // Update student details
        $updateStudent = $students->update([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $request->input('email'),
            'section' => $request->input('section'),
            'major' => $request->input('major'),
            'position' => $updatedPositions,
            'matchedCompany' => $updatedMatchedCompany,
            'hiredCompany' => $request->input('hiredCompany'),
            'status' => $request->input('status'),
            'updated_at' => now(),
        ]);


        return redirect(route('coordinator_student-list'))->with('success', 'Student updated successfully.');
    }


    public function toggleStatus($id)
    {
        // Find the student by ID
        $students = Student::findOrFail($id);

        // Toggle the status
        $newStatus = ($students->status == 1) ? 2 : 1;
        $students->status = $newStatus;

        // Save the changes
        $students->save();

        $message = ($newStatus == 2) ? 'Student updated status to Inactive.' : 'Student updated status to Active.';

        // Redirect back or wherever you need
        return redirect(route('coordinator_student-list'))->with('success', $message);
    }

    public function studentInfo($id)
    {
        // Find a student with the given $id
        $student = Student::find($id);

        // If the student is not found, redirect back with an error message
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        $journals = Journal::where('studentID', $id)->orderBy('journalNumber', 'asc')->get();


        // Return a view named 'coordinator.student_info' with both 'student' and 'journals' variables
        return view('coordinator.student_info', compact('student', 'journals'));
    }
}
