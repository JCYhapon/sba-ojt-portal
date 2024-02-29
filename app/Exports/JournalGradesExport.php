<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\User;
use App\Models\Student;
use App\Models\Journal;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JournalGradesExport implements FromCollection, WithHeadings, WithColumnFormatting, ShouldAutoSize
{
    public function collection()
    {
        // Retrieve Major from the currently authenticated user
        $userMajor = Auth::user()->major;

        // Retrieve all Students with the same major, sorted by last name in ascending order
        $students = Student::where('major', $userMajor)
            ->orderBy('lastName', 'asc')
            ->get();

        // Initialize an empty collection to hold the data
        $data = collect();

        // Retrieve the grades for the students
        foreach ($students as $student) {
            // Retrieve the grades for the current student
            $studentGrades = Journal::where('studentID', $student->studentID)->pluck('grade');

            // Push the student's name into the data collection
            $row = [
                'Student Name' => $student->lastName . ', ' . $student->firstName,
            ];

            // If the student has grades, include them in the row; otherwise, mark as "N/A"
            if ($studentGrades->isNotEmpty()) {
                // Initialize an index for the grade
                $gradeIndex = 1;

                // Push each grade into the data collection as a separate column
                foreach ($studentGrades as $grade) {
                    $row['Grade ' . $gradeIndex++] = $grade;
                }
            } else {
                // Mark as "N/A" if the student has no grades
                $row['Grade'] = '';
            }

            $data->push($row);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Student Name',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '10',
            '11',
            '12',
            '13',
            '14',
            '15',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => '200',
        ];
    }
}
