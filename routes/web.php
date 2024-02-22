<?php

use App\Http\Controllers\CoordinatorUserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\MatchingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportReportController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//LANDING PAGE
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//FOR ADMIN
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin')->middleware('admin'); // THIS IS ALSO FOR DASHBOARD PAGE

Route::get('/coordinator-profile', function () {
    return view('coordinator.profile');
})->name('coordinator_profile');

//FOR STUDENT
Route::get('/student', function () {
    return view('student.dashboard');
})->name('student')->middleware('student'); // THIS IS ALSO FOR STUDENT DASHBOARD PAGE

Route::get('/company-list', function () {
    return view('student.company_list');
})->name('student_company-list'); // STUDENT COMPANY-LIST PAGE

Route::get('/journal', function () {
    return view('student.journal');
})->name('student_journal'); // STUDENT JOURNAL PAGE

Route::get('/student-profile', function () {
    return view('student.profile');
})->name('student_profile'); // STUDENT PROFILE PAGE



//FOR COORDINATOR
Route::get('/coordinator', function () {
    return view('coordinator.dashboard');
})->name('coordinator')->middleware('coordinator');

Route::get('/coordinator_company-list', function () {
    return view('coordinator.company_list');
})->name('coordinator_company-list'); // COORDINATOR COMPANY-LIST PAGE

Route::get('/coordinator_student-list', [CoordinatorUserController::class, 'studentlist'])->name('coordinator_student-list'); // COORDINATOR STUDENT-LIST

Route::get('/coordinator_student-list.create', [CoordinatorUserController::class, 'create'])->name('coordinator_student-list.create'); // COORDINATOR CREATE STUDENT-LIST

Route::post('/coordinator_student-list', [CoordinatorUserController::class, 'store'])->name('coordinator_student-list.store'); // COORDINATOR STORE STUDENT

Route::get('/coordinator_student-journal', function () {
    return view('coordinator.student_journal');
})->name('coordinator_student-journal'); // COORDINATOR COMPANY-LIST PAGE

/*
|----------------------------------------------------------------
| Company Controller                                            |
|---------------------------------------------------------------|
| All Functions in Company Controller                           |
|----------------------------------------------------------------
*/
Route::resource('companies', CompanyController::class);
// ----Action Edit
Route::get('/coordinator_company-create', [CompanyController::class, 'createCompany'])->name('coordinator.company_create');
Route::post('/coordinator_company-store', [CompanyController::class, 'storeCompany'])->name('coordinator.company_store');

Route::get('/coordinator_company-edit/{company}', [CompanyController::class, 'editCompany'])->name('coordinator.company_edit');
Route::put('/coordinator_company-update/{company}', [CompanyController::class, 'updateCompany'])->name('coordinator.company_update');

Route::get('coordinator_company-list', [CompanyController::class, 'getCompany'])->name('coordinator_company-list');
Route::get('coordinator_company-page', [CompanyController::class, 'getCompany'])->name('coordinator_company-page');

Route::get('/coordinator/company/{id}', [CompanyController::class, 'companyInfo'])->name('coordinator_company_info');

Route::get('/coordinator_company-create', [CompanyController::class, 'createCompany'])->name('coordinator.company_create');
Route::post('/coordinator_company-store', [CompanyController::class, 'storeCompany'])->name('coordinator.company_store');

Route::get('/coordinator_company-edit/{company}', [CompanyController::class, 'editCompany'])->name('coordinator.company_edit');
Route::put('/coordinator_company-update/{company}', [CompanyController::class, 'updateCompany'])->name('coordinator.company_update');

Route::post('/coordinator/company/{id}/toggle-status', [CompanyController::class, 'toggleStatus'])->name('coordinator.company_toggle_status');

/*
|----------------------------------------------------------------
| Coordinator User Controller                                   |
|---------------------------------------------------------------|
| All Functions in Coordinator User Controller                  |
|----------------------------------------------------------------
*/

Route::get('/coordinator/student-list', [CoordinatorUserController::class, 'userStudentsInfo'])->name('coordinator.student-list');

Route::get('/coordinator/student/{id}', [CoordinatorUserController::class, 'studentInfo'])->name('coordinator_student_info');

Route::get('/coordinator/student-list', [CoordinatorUserController::class, 'userStudentsInfo'])->name('coordinator.student-list');

Route::get('/coordinator_student-list/{students}/edit', [CoordinatorUserController::class, 'edit'])->name('coordinator_student-list.edit'); // COORDINATOR EDIT STUDENT

Route::put('/coordinator_student-list/{students}/update', [CoordinatorUserController::class, 'update'])->name('coordinator_student-list.update'); // COORDINATOR UPDATE STUDENT

Route::post('/coordinator_student-list/students/{id}/toggle-status', [CoordinatorUserController::class, 'toggleStatus'])->name('coordinator_student-list.toggleStatus');

Route::post('/removeMatchedCompanies', [StudentController::class, 'removeMatchedCompanies'])->name('student.remove-matched-company');
/*
|----------------------------------------------------------------
| Dashboard Controller                                          |
|---------------------------------------------------------------|
| All Functions in Dashboard Controller                         |
|----------------------------------------------------------------
*/
Route::get('/coordinator', [DashboardController::class, 'getCoordinatorDashboardData'])->name('coordinator');

Route::get('/student', [DashboardController::class, 'getStudentDashboardData'])->name('student');

/*
|----------------------------------------------------------------
| Journal Controller                                            |
|---------------------------------------------------------------|
| All Functions in Journalr Controller                          |
|----------------------------------------------------------------
*/
Route::get('/journal',  [JournalController::class, 'journalStudent'])->name('student_journal');

Route::get('/coordinator_student-journal', [JournalController::class, 'journalCoordinator'])->name('coordinator_student-journal');

Route::get('/journal/create',  [JournalController::class, 'createJournal'])->name('create_journal');

Route::post('/journal/store',  [JournalController::class, 'storeJournal'])->name('store_journal');

Route::get('/edit-journal/{journal}', [JournalController::class, 'editJournal'])->name('edit_journal');

Route::put('/update-journal/{journalID}', [JournalController::class, 'updateJournal'])->name('update_journal');

Route::get('/coordinator/student-journal-grade/{journal}', [JournalController::class, 'studentJournalGrade'])->name('student.journal.grade');

Route::post('/grade-journal/{journalID}', [JournalController::class, 'gradeJournal'])->name('grade.journal');

Route::get('/mark-as-unread/{journalID}', [JournalController::class, 'markAsUnread'])->name('mark.unread');

/*
|----------------------------------------------------------------
| Student Controller                                            |
|---------------------------------------------------------------|
| All Functions in Student Controller                          |
|----------------------------------------------------------------
*/
Route::get('/coordinator/student-list', [StudentController::class, 'studentHiredCompany'])->name('coordinator.student-list');

Route::get('/student-profile', [StudentController::class, 'journalRenderedHours'])->name('student_profile');

Route::get('/company-list', [StudentController::class, 'displayCompany'])->name('student_company-list');

Route::get('/matched-company', [StudentController::class, 'displayMatchedCompany'])->name('matched.company.list');

Route::get('/profile/edit/', [StudentController::class, 'editProfile'])->name('profile.edit');

Route::put('/profile/update', [StudentController::class, 'updateProfile'])->name('profile.update');

Route::get('/password/edit/', [StudentController::class, 'editPassword'])->name('password.edit');

Route::put('/password/update', [StudentController::class, 'updatePassword'])->name('password.update');

Route::get('/profile', [StudentController::class, 'journalRenderedHours'])->name('profile');

Route::get('/coordinator/student-list', [StudentController::class, 'studentHiredCompany'])->name('coordinator.student-list');

Route::post('/removeStudentPosition', [StudentController::class, 'removePositions'])->name('student.remove-positions');

Route::post('/add-supervisor', [StudentController::class, 'addSupervisor'])->name('add.supervisor');

Route::get('/student/company/{id}', [StudentController::class, 'companyInformation'])->name('student_company_information');

/*
|----------------------------------------------------------------
| Company Controller                                            |
|---------------------------------------------------------------|
| All Functions in Company Controller                           |
|----------------------------------------------------------------
*/
Route::get('/admin_company-list', [AdminController::class, 'companyAdmin'])->name('admin_company-page');

Route::get('/admin_coordinator-list', [AdminController::class, 'coordinatorList'])->name('admin_coordinator-page');

Route::get('/admin_student-list', [AdminController::class, 'studentList'])->name('admin_student-page');

/*
|----------------------------------------------------------------
|   Matching Controller                                         |
|---------------------------------------------------------------|
| All Routes for MatchingController                             |
|----------------------------------------------------------------
*/
Route::get('/match-students', [MatchingController::class, 'matchStudentsWithCompanies'])->name('match-students');

/*
|----------------------------------------------------------------
|   Export Report Controller                                    |
|---------------------------------------------------------------|
| All Routes for ExportReportController                         |
|----------------------------------------------------------------
*/

Route::get('/coordinator-profile', [ExportReportController::class, 'journalGrade'])->name('coordinator_profile');

Route::get('/export-journal-grades', [ExportReportController::class, 'exportJournalGrades'])->name('export.journal.grades');
