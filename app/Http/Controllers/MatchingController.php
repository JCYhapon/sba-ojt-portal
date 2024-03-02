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
        $userId = auth()->user()->schoolID;
        $student = Student::where('studentID', $userId)->first();
        $studentWorkType = $student->workType;

        if (!$studentWorkType) {
            return;
        }

        $companies = Company::where('status', 1)
            ->whereJsonDoesntContain('position', [])
            ->where('workType', $studentWorkType)
            ->get();
        $matchingResults = [];

        foreach ($companies as $company) {
            $studentPosition = $student->position;
            $companyPosition = $company->position;
            $studentSkills = $student->skills;
            $companySkills = $company->skills;
            $studentWorkType = $student->workType;
            $companyWorkType = $company->workType;

            // Check if the work types match
            if ($companyWorkType == $studentWorkType) {
                // Check if positions match
                if ($this->checkPositionMatch($studentPosition, $companyPosition)) {
                    // Check if skills match
                    if ($this->checkSkillsMatch($studentSkills, $companySkills)) {
                        $matchingResults[] = [
                            'student' => $student,
                            'company' => $company,
                        ];
                        $student->suggestedCompany = array_merge($student->suggestedCompany, [$company->id]);
                        $student->save();
                    }
                }
            }
        }
    }

    private function checkPositionMatch($studentPositions, $companyPositions)
    {
        $matchingValues = array_intersect($studentPositions, $companyPositions);
        $matchingCount = count($matchingValues);

        return $matchingCount > 0;
    }

    private function checkSkillsMatch($studentSkills, $companySkills)
    {
        // Convert comma-separated skills into arrays
        $studentSkillsArray = explode(',', $studentSkills);
        $companySkillsArray = explode(',', $companySkills);

        // Check if there is any skill common between student and company
        foreach ($studentSkillsArray as $studentSkill) {
            if (in_array($studentSkill, $companySkillsArray)) {
                return true;
            }
        }
        return false;
    }
}
