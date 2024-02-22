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

class JournalGradesExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    public function collection()
    {
        // Retrieve Major from the currently authenticated user
        $userMajor = Auth::user()->major;

        // Retrieve all Students with the same major, sorted by last name in ascending order
        $studentIds = Student::where('major', $userMajor)
            ->orderBy('lastName', 'asc')
            ->pluck('students.studentID');

        // Initialize an empty collection to hold the data
        $data = collect();

        // Retrieve the grades for the students
        foreach ($studentIds as $studentId) {
            $studentGrades = Journal::where('journals.studentID', $studentId)
                ->join('students', 'journals.studentID', '=', 'students.studentID')
                ->select('students.lastName', 'students.firstName', 'journals.grade')
                ->get();

            // Push the student's name into the data collection
            $row = [
                'Student Name' => $studentGrades->first()->lastName . ', ' . $studentGrades->first()->firstName,
            ];

            // Initialize an index for the grade
            $gradeIndex = 1;

            // Push each grade into the data collection as a separate column
            foreach ($studentGrades as $grade) {
                $row['Grade ' . $gradeIndex++] = $grade->grade;
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
            'A' => '20', // Set width of column A (Student Name) to 20
        ];
    }
}
