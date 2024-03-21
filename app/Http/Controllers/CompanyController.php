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
    public function getCompany(Request $request)
    {
        $searchQuery = $request->query('search'); // Retrieving search query from request

        $companies = Company::query(); // Starting the query for companies

        if ($searchQuery) {
            $companies->where('name', 'like', '%' . $searchQuery . '%'); // Filtering by company name if search query exists
        }

        if ($request->has('filter') && $request->filter === 'active') {
            $companies->where('status', 1);
        } else if ($request->has('filter') && $request->filter === 'inactive') {
            $companies->where('status', 2);
        }

        $companies = $companies->orderBy('id', 'asc')->paginate(7); // Paginate the results

        return view('coordinator.company_list', compact('companies')); // Returning the view with paginated company data
    }


    public function companyInfo($id)
    {

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
            'description',
        ]);

        $data = $request->only([
            'id',
            'name',
            'email',
            'address',
            'description'
        ]) + [
            'status' => 1,
            'position' => [],
            'hiredStudents' => [],
        ];

        Company::create($data);

        return redirect()->route('coordinator_company-list')->with('success', 'Company has been created successfully.');
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
            'positions' => 'array', // Ensure positions is provided and is an array
            'positions.*' => 'string',
            'hiredStudents',
            'workType',
            'description',
        ]);

        // Convert the input positions and hiredStudents to an array
        $hiredStudents = $request->input('hiredStudents');
        $newHiredStudents = array_map('intval', explode(',', $hiredStudents));
        $updatedPositions = $request->input('positions') ?? [];

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
            'position' => $updatedPositions,
            'hiredStudents' => $hiredStudents,
            'workType' => $request->input('workType'),
            'description' => $request->input('description'),
        ]);

        // Update the corresponding students
        // Retrieve the students based on the updated company
        $students = Student::whereIn('id', $hiredStudents)->get();

        // Update the hiredCompany column for each student
        foreach ($students as $student) {
            $student->update(['hiredCompany' => $company->id]);
        }

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
