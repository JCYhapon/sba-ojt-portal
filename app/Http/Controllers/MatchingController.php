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
        Log::info('Matching is called');
        $userId = auth()->user()->schoolID;
        $student = Student::where('studentID', $userId)->first();

        Log::info($student->workType);

        if ($student->workType === null) {
            Log::info('Goes Outside');
            if (empty($student->position)) {
                Log::info('Goes Inside');
                return view('student.matched_company-list', compact('student'));
            }
            return view('student.matched_company-list', compact('student'));
        }
        Log::info('Proceeded');

        $studentWorkType = $student->workType;
        $studentSuggestedCompanies = collect($student->suggestedCompany);
        $studentSuggestedCompanyIds = $studentSuggestedCompanies->pluck('id')->toArray();

        $companies = Company::where('status', 1)
            ->where('workType', $studentWorkType)
            // ->whereNotIn('id', $studentSuggestedCompanyIds)
            ->get();

        $matchingResults = [];

        Log::info('Past Validation');

        foreach ($companies as $company) {
            $studentPosition = $student->position;
            $companyPosition = $company->position;

            // Check if the work types match
            if ($company->workType == $studentWorkType) {
                Log::info('WorkType Matching');
                if ($this->checkPositionMatch($studentPosition, $companyPosition)) {
                    Log::info('Position Matching');
                    $matchingResults[] = [
                        'student' => $student,
                        'company' => $company,
                    ];
                    $student->suggestedCompany = array_merge($student->suggestedCompany, [$company->id]);
                    $student->save();
                }
            }
        }

        return view('student.matched_company-list', compact('student'));
    }

    private function checkPositionMatch($studentPositions, $companyPositions)
    {
        $matchingValues = array_intersect($studentPositions, $companyPositions);
        $matchingCount = count($matchingValues);

        return $matchingCount > 0;
    }

    // private function checkSkillsMatch($studentSkills, $companySkills)
    // {
    //     // Convert comma-separated skills into arrays
    //     $studentSkillsArray = explode(',', $studentSkills);
    //     $companySkillsArray = explode(',', $companySkills);

    //     // Check if there is any skill common between student and company
    //     foreach ($studentSkillsArray as $studentSkill) {
    //         if (in_array($studentSkill, $companySkillsArray)) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }
}
