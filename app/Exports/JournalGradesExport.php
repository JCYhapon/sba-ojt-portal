<?php

namespace App\Exports;

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
    protected $section;

    public function __construct($section)
    {
        $this->section = $section;
    }

    public function collection()
    {
        // Filter students based on the selected section
        $students = Student::where('major', Auth::user()->major)
            ->when($this->section !== 'all', function ($query) {
                return $query->where('section', $this->section);
            })
            ->orderBy('lastName', 'asc')
            ->get();

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
