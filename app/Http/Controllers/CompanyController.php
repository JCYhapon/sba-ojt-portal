<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class CompanyController extends Controller
{
    public function getCompany()
    {
        $companies = Company::orderBy('id','asc')->paginate(10);
        return view('coordinator.company_list', compact('companies'));
    }

    public function companyInfo($id) {

        $companies = Company::find($id);

        if (!$companies) {
            return redirect()->back()->with('error', 'Company not found.');
        }


        return view('coordinator.company_info', ['companies' => $companies]);
    }

    // Retrieve information for the hired students
    private function companyHiredStudents($companies)
    {
        $hiredStudents = $companies->hiredStudents;
        $studentIDs = json_decode($hiredStudents, true);

        return Student::whereIn('studentID', $studentIDs)->get();
    }

    //Create
    public function createCompany()
    {
        return view('coordinator.company_list-create');
    }


    public function storeCompany(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        $data = $request->only([
            'id',
            'name',
            'email',
            'address',
        ]) + [
            'status' => 1,
            'position' => [],
            'hiredStudents' => [],
        ];

        Company::create($data);

        return redirect()->route('coordinator_company-list')->with('success','Company has been created successfully.');
    }

    public function editCompany(Company $company)
    {
        $users = User::where('role', 3)->get();

        return view('coordinator.company_list-edit', compact('company', 'users'));
    }


    public function updateCompany(Request $request, Company $company)
    {
        $request->validate([
            'id',
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'status' => 'required',
            'position',
            'hiredStudents',
        ]);

        // Convert the input positions and hiredStudents to an array
        $newPositions = explode(',', $request->input('position'));
        $hiredStudents = $request->input('hiredStudents');
        $newHiredStudents = array_map('intval', explode(',', $hiredStudents));

        // Check if a position is selected (not empty) before merging
        if ($request->filled('position')) {
            // Merge the new positions with the existing positions
            $positions = array_merge($company->position, $newPositions);
        } else {
            $positions = $company->position;
        }

        // Check if a hired Position is selected (not empty) before merging
        if ($request->filled('hiredStudents')) {
            // Merge the new hiredPosition with the existing positions
            $hiredStudents = array_merge($company->hiredStudents, $newHiredStudents);
        } else {
            $hiredStudents = $company->hiredStudents;
        }

        // Updating Company
        $company->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'status' => $request->input('status'),
            'position' => $positions,
            'hiredStudents' => $hiredStudents,
        ]);

        // Update the corresponding students
        // Retrieve the students based on the updated company
        $students = Student::whereIn('id', $hiredStudents)->get();

        // Update the hiredCompany column for each student
        foreach ($students as $student) {
            $student->update(['hiredCompany' => $company->id]);
        }

        //-----------------------------------------------------------
        // Create logic for
        // removing company ID from the hiredCompany students table
        // removing student ID from the hiredStudent companies table
        //                  - OBRA NANG KIKS
        //-----------------------------------------------------------

        return redirect()->route('coordinator_company-list')->with('success', 'Company has been updated successfully.');
    }


    public function toggleStatus($companyId)
    {
        // Find the company by ID
        $company = Company::findOrFail($companyId);

        // Toggle the status
        $newStatus = ($company->status == 1) ? 2 : 1;
        $company->status = $newStatus;

        // Save the changes
        $company->save();

        // Define the message for redirection
        $message = ($newStatus == 2) ? 'Company status has been updated to For Renewal' : 'Company status has been updated to Active';

        // Redirect back or wherever you need
        return redirect()->route('coordinator_company-list')->with('success', $message);
    }
}
