<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        $userSchoolID = auth()->user()->schoolID;
        $student = Student::where('studentID', $userSchoolID)->first();
        $user = Auth::user();
        if ($user->role !== 1) {
            $companies = Company::where('id', $student->hiredCompany)->first();
        }
        if ($student) {
            $totalRenderedHours = Journal::where('studentID', $student->id)->sum('hoursRendered');
            $neededHours = $student->neededHours;
            $remainingHours = $student->neededHours - $totalRenderedHours;
            if ($remainingHours === 0) {
                $student->status = 3;
                $student->save();
            }
        } else {
            $totalRenderedHours = 0;
            $remainingHours = 0;
        }
        if ($user->role === 2) {
            return view('coordinator.profile');
        }

        return view('student.profile', compact(
            'totalRenderedHours',
            'remainingHours',
            'neededHours',
            'companies'
        ));
    }

    public function displayCompany()
    {
        $companies = Company::orderBy('id', 'asc')->paginate(9);
        return view('student.company_list', compact('companies'));
    }

    public function editProfile(Student $student)
    {
        return view('student.profile-edit', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        Log::info('Update Profile Student');
        $userSchoolID = auth()->user()->schoolID;
        $user = User::findOrFail($userSchoolID);

        $student = Student::where('studentID', $userSchoolID)->first();

        $request->validate([
            'profilePicture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'positions' => 'array',
            'positions.*' => 'string',
            'supervisor',
            'hiredCompany',
            'workType',
        ]);

        $input = [];

        if ($request->hasFile('profilePicture')) {
            $profilePicture = $request->file('profilePicture');
            $profilePicturePath = 'profilePicture/';
            $profilePictureImage = date('YmdHis') . "." . $profilePicture->getClientOriginalExtension();
            $profilePicture->move($profilePicturePath, $profilePictureImage);
            $input['profilePicture'] = $profilePicturePath . $profilePictureImage;
        }

        if (!empty($input['profilePicture'])) {
            $user->update([
                'profilePicture' => $input['profilePicture'],
            ]);
        }

        $updatedPositions = $request->input('positions') ?? [];

        if ($request->filled('hiredCompany')) {
            $hiredCompany =  $request->input('hiredCompany');
        } else {
            $hiredCompany = $student->hiredCompany;
        }

        if ($request->filled('supervisor')) {
            $supervisor =  $request->input('supervisor');
        } else {
            $supervisor = $student->supervisor;
        }

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
        $userSchoolID = auth()->user()->schoolID;
        $student = Student::where('studentID', $userSchoolID)->first();

        $request->validate([
            'positions' => 'array',
            'positions.*' => 'string',
        ]);


        $updatedPositions = $request->input('positions') ?? [];
        $updateStudent = $student->update([
            'position' => $updatedPositions,
        ]);

        return back()->with('success', 'Positions updated successfully');
    }

    public function addSupervisor(Request $request)
    {
        $userSchoolID = auth()->user()->schoolID;
        $student = Student::where('studentID', $userSchoolID)->first();

        $request->validate([
            'supervisor' => 'required',
        ]);

        $updateStudent = $student->update([
            'supervisor' => $request->input('supervisor'),
        ]);

        return back()->with('success', 'Supervisor updated successfully');
    }

    public function companyInformation($id)
    {

        $companies = Company::find($id);

        if (!$companies) {
            return redirect()->back()->with('error', 'Company not found.');
        }


        return view('student.company_info', ['companies' => $companies]);
    }

    public function editPassword(Student $student)
    {
        return view('student.update-password', compact('student'));
    }

    public function updatePassword(Request $request)
    {
        Log::info('Update Password');
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        Log::info('====================');
        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'The old password is incorrect.');
        }
        $updateStudent = $user->update([
            'password' => Hash::make($request->new_password),
        ]);
        Log::info($user->role);
        if ($user->role === 3) {
            Log::info('It goes here');
            return redirect()->route('student_profile')->with('success', 'Password updated successfully.');
        } else if ($user->role === 2) {
            return redirect()->route('coordinator_profile')->with('success', 'Student password updated successfully.');
        } else if ($user->role === 1) {
            return redirect()->route('admin')->with('success', 'Student password updated successfully.');
        }
    }
}
