<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function companyAdmin()
    {
        $companies = Company::orderBy('id', 'asc')->paginate(12);
        return view('admin.company', compact('companies'));
    }

    public function coordinatorList()
    {
        $users = User::where('role', 2)->paginate(12);

        return view('admin.coordinator', ['users' => $users]);
    }

    public function studentList()
    {
        $users = User::where('role', 3)->paginate(12);

        return view('admin.student', ['users' => $users]);
    }
}
