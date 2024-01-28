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

class MatchingController extends Controller
{
    public function matchStudentsWithCompanies()
    {
        // Log matching process started
        Log::info('Matching process started.');

        // Get the authenticated user's schoolID
        $userId = auth()->user()->schoolID;

        // Log processing matching for student ID
        Log::info('Processing matching for Student ID: ' . $userId);

        // Get the student based on the schoolID
        $student = Student::where('studentID', $userId)->first();

        // Get all companies
        $companies = Company::all();

        // Initialize the matching results array
        $matchingResults = [];

        // Iterate through each company
        foreach ($companies as $company) {
            $studentPosition = $student->position;
            $companyPosition = $company->position;
            Log::info('=========================================================================================================');
            Log::info('Checking if there is a match for Company ID: ' . $company->id . ' with Student ID: ' . $student->studentID);
            Log::info('Company Worktype : '. $company->workType);
            Log::info('Student Worktype : '. $student->workType);
            Log::info('====================================================');
            Log::info('Position Company:', $companyPosition);
            Log::info('====================================================');
            Log::info('Position Student:', $studentPosition);

            // Check if the company's workType matches the student's workType
            if ($company->workType == $student->workType) {
                if ($this->checkPositionMatch($studentPosition, $companyPosition)) {
                    // Add the match to the results
                    $matchingResults[] = [
                        'student' => $student,
                        'company' => $company,
                    ];

                    // Log the match
                    Log::info('Match found for Company ID: ' . $company->id . ' with Student ID: ' . $student->studentID);

                    // Store the company ID in the student's suggestedCompany column
                    $student->suggestedCompany = array_merge($student->suggestedCompany, [$company->id]);

                    $student->save();

                }
            }
        }

        // Process the matching results (you can implement your logic here)

        // Log matching process completed
        Log::info('Matching process completed.');

        // Redirect to the student profile page
        return redirect('student-profile');
    }

    private function checkPositionMatch($studentPositions, $companyPositions)
    {
        $matchingValues = array_intersect($studentPositions, $companyPositions);
        $matchingCount = count($matchingValues);

        // Log the position match result
        Log::info('Position match result: ' . $matchingCount);

        // Return true if there is at least one matching position
        return $matchingCount > 0;
    }
}
