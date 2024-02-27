<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use Maatwebsite\Excel\Concerns\ToCollection;

class StudentImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows->slice(1) as $row) {
            Log::info('File Being Transferred');
            User::create([
                'id' => $row[0], // Assuming 'Student ID' is the first column
                'schoolID' => $row[0], // Assuming 'Student ID' is the first column
                'name' => $row[1] . ' ' . $row[2], // Assuming 'Last Name' is the second column and 'First Name' is the third column
                'email' => $row[3], // Assuming 'Email' is the fourth column
                'role' => 3,
                'major' => $row[4], // Assuming 'Major' is the fifth column
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'email_verified_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Student::create([
                'id' => $row[0], // Assuming 'Student ID' is the first column
                'studentID' => $row[0], // Assuming 'Student ID' is the first column
                'firstName' => $row[2], // Assuming 'First Name' is the third column
                'lastName' => $row[1], // Assuming 'Last Name' is the second column
                'email' => $row[3], // Assuming 'Email' is the fourth column
                'major' => $row[4], // Assuming 'Major' is the fifth column
                'section' => $row[5], // Assuming 'Section' is the sixth column
                'workType' => null,
                'jobTitle' => null,
                'suggestedCompany' => [],
                'matchedCompany' => [],
                'hiredCompany' => null,
                'position' => [],
                'supervisor' => null,
                'status' => 1,
                'neededHours' => 600,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
