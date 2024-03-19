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
        Log::info('Matching Controller Being Called');
        $userId = auth()->user()->schoolID;
        $student = Student::where('studentID', $userId)->first();

        $isWorkTypeNull = $student->workType === null;
        $isEmptyPosition = empty($student->position);
        $isHiredNotNull = $student->hiredCompany !== null;

        $isInvalidStudent = $isWorkTypeNull || $isEmptyPosition || $isHiredNotNull;

        // Empty student Suggested company
        $student->update([
            'suggestedCompany' => [],
        ]);

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
            ->get();

        $matchingResults = [];
        $matchFound = false;

        foreach ($companies as $company) {
            $companyPosition = $this->preprocessPosition($company->position);
            Log::info('Company :' . $company);

            if ($companyPosition === false) {
                continue;
            }

            foreach ($companyPosition as $companyPos) {
                if ($this->tokenBasedMatching($studentPosition, $companyPos)) {
                    $matchingResults[] = [
                        'student' => $student,
                        'company' => $company,
                    ];
                    $student->suggestedCompany = array_merge($student->suggestedCompany, [$company->id]);
                    $student->save();
                    $matchFound = true;
                    break;
                }
            }
        }

        return view('student.matched_company-list', compact('student'));
    }

    private function preprocessPosition($position)
    {
        Log::info('Preprocess Occurs');
        $processedPositions = [];

        foreach ($position as $pos) {
            $processedPositions[] = strtolower($pos);
        }
        return $processedPositions;
    }


    private function tokenBasedMatching($studentPositions, $companyPosition)
    {
        $levenshteinThreshold = 5;

        $studentPositions = array_map(function ($pos) {
            return str_replace(['junior ', 'senior '], '', $pos);
        }, $studentPositions);

        $companyPosition = str_replace(['junior ', 'senior '], '', $companyPosition);

        $matchingResults = [];

        foreach ($studentPositions as $studentPos) {
            $levenshteinDistance = levenshtein($studentPos, $companyPosition);

            Log::info('The distance between ' . $studentPos . ' and ' . $companyPosition . ': ' . $levenshteinDistance);

            if ($levenshteinDistance <= $levenshteinThreshold) {
                return true;
            }
        }

        return false;
    }
}
