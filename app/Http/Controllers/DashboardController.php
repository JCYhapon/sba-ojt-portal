<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Company;
use App\Models\Journal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


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
        $user = Auth::user();
        $userID = $user->schoolID;
        $student = Student::where('studentID', $userID)->first();

        $hiredCompany = $student->hiredCompany;

        if (!$hiredCompany) {
            $companyName = 0;
        } else {
            $company = Company::find($hiredCompany);
            $companyName = $company->name;
        }

        $totalRenderedHours = 0;
        $remainingHours = 0;
        $neededHours = 0;

        if ($student) {
            $totalRenderedHours = Journal::where('studentID', $student->id)->sum('hoursRendered');
            $neededHours = $student->neededHours;
            $remainingHours = $neededHours - $totalRenderedHours;
            if ($remainingHours === 0) {
                $student->status = 3;
                $student->save();
            }
        }

        // Fetch the major of the authenticated student
        $major = $student->major;

        if ($user->role === 2) {
            return view('coordinator.profile');
        }

        $companies = null;
        if ($user->role !== 1) {
            $companies = Company::where('id', $hiredCompany)->first();
        }

        return view('student.dashboard', [
            'companyName' => $companyName,
            'student' => $student,
            'totalRenderedHours' => $totalRenderedHours,
            'remainingHours' => $remainingHours,
            'neededHours' => $neededHours,
            'companies' => $companies,
            'major' => $major, // Pass the $major variable to the view

        ]);
    }


    public function getAdminDashboardData()
    {
        // Get Students Count
        $accountingTotalStudents = Student::where('major', 'Accounting')->count();
        $managementTotalStudents = Student::where('major', 'Management')->count();

        // Coordinators Name
        $accountingCoordinator = User::where('major', 'Accounting')
            ->where('role', 2)
            ->where('status', 1)
            ->first();

        $managementCoordinator = User::where('major', 'Management')
            ->where('role', 2)
            ->where('status', 1)
            ->first();

        $accountingCoordinatorName = $accountingCoordinator ? $accountingCoordinator->name : "No Accounting Coordinator found";
        $managementCoordinatorName = $managementCoordinator ? $managementCoordinator->name : "No Management Coordinator found";

        // Get Sections Count
        $accountingTotalSections = Student::where('major', 'Accounting')
            ->distinct('section')
            ->count('section');

        $managementTotalSections = Student::where('major', 'Management')
            ->distinct('section')
            ->count('section');

        // Count Student per Section
        $accountingStudentSection = Student::select('section', DB::raw('COUNT(*) as student_count'))
            ->where('major', 'Accounting')
            ->groupBy('section')
            ->get();

        $managementStudentSection = Student::select('section', DB::raw('COUNT(*) as student_count'))
            ->where('major', 'Management')
            ->groupBy('section')
            ->get();


        // Get Company Count
        $totalCompanies = Company::count();
        $totalCompaniesWithStatus1 = Company::where('status', 1)->count();
        $totalCompaniesWithStatus2 = Company::where('status', 2)->count();

        return view('admin.dashboard', [
            'accountingTotalStudents' => $accountingTotalStudents,
            'managementTotalStudents' => $managementTotalStudents,
            'accountingCoordinatorName' => $accountingCoordinatorName,
            'managementCoordinatorName' => $managementCoordinatorName,
            'accountingTotalSections' => $accountingTotalSections,
            'managementTotalSections' => $managementTotalSections,
            'accountingStudentSection' => $accountingStudentSection,
            'managementStudentSection' => $managementStudentSection,
        ]);
    }
}
