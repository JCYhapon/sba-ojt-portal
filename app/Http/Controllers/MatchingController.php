<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\Student;
use Illuminate\Support\Facades\Log;

class MatchingController extends Controller
{
    public function matchStudentsWithCompanies()
    {
        Log::info('Matching Controlle Being Called');
        $userId = auth()->user()->schoolID;
        $student = Student::where('studentID', $userId)->first();

        $isWorkTypeNull = $student->workType === null;
        $isEmptyPosition = empty($student->position);
        $isHiredNotNull = $student->hired !== null;

        $isInvalidStudent = $isWorkTypeNull || $isEmptyPosition || $isHiredNotNull;

        if ($isInvalidStudent) {
            Log::info('Inside the first RULE');
            return view('student.matched_company-list', compact('student'));
        }
        Log::info('Student is valid');
        $studentWorkType = $student->workType;
        $studentPosition = $this->preprocessPosition($student->position);

        $studentSuggestedCompanies = collect($student->suggestedCompany);
        $studentSuggestedCompanyIds = $studentSuggestedCompanies->pluck('id')->toArray();


        $companies = Company::where('status', 1)
            ->where('workType', $studentWorkType)
            ->whereNotIn('id', $studentSuggestedCompanyIds)
            ->whereNot('position', '[]')
            ->get();

        $matchingResults = [];

        foreach ($companies as $company) {
            Log::info('Company Retrieved :' . $company->name);
            $companyPosition = $this->preprocessPosition($company->position);
            Log::info('Student Tokens: ' . print_r($studentPosition, true));
            Log::info('Company Tokens: ' . print_r($companyPosition, true));
            if ($this->tokenBasedMatching($studentPosition, $companyPosition)) {
                $matchingResults[] = [
                    'student' => $student,
                    'company' => $company,
                ];
                $student->suggestedCompany = array_merge($student->suggestedCompany, [$company->id]);
                $student->save();
            }
        }

        return view('student.matched_company-list', compact('student'));
    }

    private function preprocessPosition($position)
    {
        Log::info('Preprocess Occurs');
        foreach ($position as $positions)
            $position = strtolower($positions);
        return $position;
    }

    private function tokenBasedMatching($studentPosition, $companyPosition)
    {
        Log::info('Token Based Occurs');
        $studentTokens = preg_split('/\s+/', $studentPosition);
        $companyTokens = preg_split('/\s+/', $companyPosition);

        Log::info('Student Tokens: ' . print_r($studentTokens, true));
        Log::info('Company Tokens: ' . print_r($companyTokens, true));

        $commonTokens = array_intersect($studentTokens, $companyTokens);
        Log::info('Common Tokens: ' . print_r($commonTokens, true));
        $threshold = 1;

        return count($commonTokens) >= $threshold;
    }
}
