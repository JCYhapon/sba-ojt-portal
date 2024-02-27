<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{

    public function redirectToStudentBulkList()
    {
        return view('coordinator.student_list-bulk');
    }

    public function import(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');

        Excel::import(new StudentImport, $file);

        return redirect()->back()->with('success', 'Students imported successfully.');
    }
}
