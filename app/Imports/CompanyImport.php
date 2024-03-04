<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\User;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use Maatwebsite\Excel\Concerns\ToCollection;

class CompanyImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows->slice(1) as $row) {
            $description = null;
            if (empty($row[0]) || empty($row[1]) || empty($row[2])) {
                if (empty($row[3])) {
                    $description = null;
                } else {
                    $description = $row[3];
                }
                continue;
            }
            Company::create([
                'name' => $row[0],
                'email' => $row[1],
                'address' => $row[2],
                'description' => $description,
                'status' => 1,
                'workType' => null,
                'position' => [],
                'skills' => [],
                'hiredStudents' => [],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
