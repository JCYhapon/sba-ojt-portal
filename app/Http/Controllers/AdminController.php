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

    public function createCoordinator()
    {
        return view('admin.coordinator_create');
    }

    public function storeCoordinator(Request $request)
    {
        Log::info('Store Function Called');
        $request->validate([
            'studentID' => 'required|min:8|max:8',
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'major' => 'required',
        ]);
        Log::info('Store Function validate');
        // Create user details first
        $user = User::create([
            'id' => $request->input('studentID'),
            'schoolID' => $request->input('studentID'),
            'name' => $request->input('firstName') . ' ' . $request->input('lastName'),
            'email' => $request->input('email'),
            'role' => 2,
            'major' => $request->input('major'),
            'password' => Hash::make($request->input('password')),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Log::info('Store Function Create');

        return redirect(route('admin_coordinator-page'))->with('success', 'Coordinator created successfully.');
    }

    public function editCoordinator(User $user)
    {
        return view('admin.coordinator_edit', compact('user'));
    }

    public function updateCoordinator(Request $request, User $user)
    {
        Log::info('update Function Called');
        $request->validate([
            'name' => 'string',
            'email' => 'email',
            'password',
            'major',
        ]);
        Log::info('update Function validate');
        if ($request->has('password') && $request->input('password') !== null) {
            $password = Hash::make($request->input('password'));
        } else {
            $password = $user->password;
        }
        Log::info('update Function password');
        $updateUser = $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'major' => $request->input('major'),
            'password' => $password,
            'updated_at' => now(),
        ]);
        Log::info('update Function save');
        return redirect(route('admin_coordinator-page'))->with('success', 'Coordinator updated successfully.');
    }
}
