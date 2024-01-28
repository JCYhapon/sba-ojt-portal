<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Company;
use App\Models\Journal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function getCoordinatorDashboardData()
    {
        $users = User::where('role', 3)->get();
        $userMajor = auth()->user()->major;

        // Getr Students Count
        $totalEnrolledStudents = Student::where('major', $userMajor)->count();
        $totalHiredStudents = Student::where('major', $userMajor)->whereNotNull('hiredCompany')->count();
        $totalNonHiredStudents = Student::where('major', $userMajor)->whereNull('hiredCompany')->count();

        // Get Company Count
        $totalCompanies = Company::count();
        $totalCompaniesWithStatus1 = Company::where('status', 1)->count();
        $totalCompaniesWithStatus2 = Company::where('status', 2)->count();

        // Get Journal Count
        $studentIDs = Student::where('major', $userMajor)->pluck('studentID');
        $totalUnreadJournals = Journal::whereIn('studentID', $studentIDs)->where('status', 1)->count();

        return view('coordinator.dashboard', [
            'users'  => $users,
            'totalEnrolledStudents'  => $totalEnrolledStudents,
            'totalHiredStudents'  => $totalHiredStudents,
            'totalNonHiredStudents'  => $totalNonHiredStudents,
            'totalCompanies' => $totalCompanies,
            'totalCompaniesWithStatus1' => $totalCompaniesWithStatus1,
            'totalCompaniesWithStatus2' => $totalCompaniesWithStatus2,
            'totalUnreadJournals' => $totalUnreadJournals,
        ]);
    }

    public function getStudentDashboardData()
    {
        $userID = auth()->user()->schoolID;

        // Search students table for a match in userID
        $student = Student::where('studentID', $userID)->first();

        // Get the hiredCompany of the student found
        $hiredCompany = $student->hiredCompany;

        // If no hiredCompany, set $companyName to 0
        if (!$hiredCompany) {
            $companyName = 0;
        } else {
            // Search company table id column for a match with hiredCompany
            $company = Company::find($hiredCompany);

            // Get the name of the company with the match id
            $companyName = $company->name;
        }

        return view('student.dashboard', [
            'companyName' => $companyName,
        ]);
    }
}
