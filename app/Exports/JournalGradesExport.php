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
        $userMajor = Auth::user()->major;
        $students = Student::where('major', $userMajor)->orderBy('lastName', 'asc')->get();

        $data = collect();

        foreach ($students as $student) {
            $studentGrades = Journal::where('studentID', $student->studentID)->pluck('grade');
            $totalGrade = $studentGrades->filter()->sum();
            $row = [
                'Student Name' => $student->lastName . ', ' . $student->firstName,
            ];

            if ($studentGrades->isNotEmpty()) {
                $includedGrades = [];

                foreach ($studentGrades as $grade) {
                    $includedGrades[] = $grade;
                }

                while (count($includedGrades) < 15) {
                    $includedGrades[] = '';
                }

                foreach ($includedGrades as $grade) {
                    $row[] = $grade;
                }
            } else {
                for ($i = 0; $i < 15; $i++) {
                    $row[] = '';
                }
            }
            $row[] = $totalGrade;

            $data->push($row);
        }

        return $data;
    }


    public function headings(): array
    {
        $headings = ['Student Name'];
        for ($i = 1; $i <= 15; $i++) {
            $headings[] = (string)$i; // Add numbers 1 to 15 as headings
        }
        $headings[] = 'Total';
        return $headings;
    }

    public function columnFormats(): array
    {
        return [
            'A' => '200',
        ];
    }
}
