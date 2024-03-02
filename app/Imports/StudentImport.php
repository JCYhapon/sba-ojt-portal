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
            if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[4])) {
                continue;
            }

            User::create([
                'id' => $row[0],
                'schoolID' => $row[0],
                'name' => $row[1] . ' ' . $row[2],
                'email' => $row[3],
                'role' => 3,
                'major' => $row[4],
                'password' => Hash::make('password'),
                'remember_token' => null,
                'email_verified_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Student::create([
                'id' => $row[0],
                'studentID' => $row[0],
                'firstName' => $row[2],
                'lastName' => $row[1],
                'email' => $row[3],
                'major' => $row[4],
                'section' => $row[5],
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
