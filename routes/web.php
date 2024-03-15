<?php

use App\Http\Controllers\CoordinatorUserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\MatchingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportReportController;
use App\Http\Controllers\ImportController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;



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

// FOR FILTERING COORDINATOR - STUDENT JOURNAL 
Route::get('/journals', [JournalController::class, 'journalCoordinator'])->name('journals.index');

//Company Filtering
Route::get('/company', [CompanyController::class, 'getCompany'])->name('company.search');


//FORGOT PASSWORD
Route::get('/forgot-password', function () {
    return view('auth.forgotpassword');
})->name('forgot-password');

//FOR ADMIN
// Route::get('/admin', function () {
//     return view('admin.dashboard');
// })->name('admin'); 

Route::get('/coordinator-profile', function () {
    return view('coordinator.profile');
})->name('coordinator_profile');

//FOR STUDENT
// Route::get('/student', function () {
//     return view('student.dashboard');
// })->name('student'); 

Route::get('/company-list', function () {
    return view('student.company_list');
})->name('student_company-list')->middleware('student'); // STUDENT COMPANY-LIST PAGE

Route::get('/journal', function () {
    return view('student.journal');
})->name('student_journal')->middleware('student'); // STUDENT JOURNAL PAGE

Route::get('/student-profile', function () {
    return view('student.profile');
})->name('student_profile'); // STUDENT PROFILE PAGE



//FOR COORDINATOR
// Route::get('/coordinator', function () {
//     return view('coordinator.dashboard');
// })->name('coordinator');

Route::get('/coordinator_company-list', function () {
    return view('coordinator.company_list');
})->name('coordinator_company-list')->middleware('coordinator'); // COORDINATOR COMPANY-LIST PAGE

Route::get('/coordinator_student-list', [CoordinatorUserController::class, 'studentlist'])->name('coordinator_student-list')->middleware('coordinator'); // COORDINATOR STUDENT-LIST

Route::get('/coordinator_student-list.create', [CoordinatorUserController::class, 'create'])->name('coordinator_student-list.create')->middleware('coordinator'); // COORDINATOR CREATE STUDENT-LIST

Route::post('/coordinator_student-list', [CoordinatorUserController::class, 'store'])->name('coordinator_student-list.store')->middleware('coordinator'); // COORDINATOR STORE STUDENT

Route::get('/coordinator_student-journal', function () {
    return view('coordinator.student_journal');
})->name('coordinator_student-journal')->middleware('coordinator'); // COORDINATOR COMPANY-LIST PAGE

/*
|----------------------------------------------------------------
| Company Controller                                            |
|---------------------------------------------------------------|
| All Functions in Company Controller                           |
|----------------------------------------------------------------
*/
Route::resource('companies', CompanyController::class);
// ----Action Edit
Route::get('/coordinator_company-create', [CompanyController::class, 'createCompany'])->name('coordinator.company_create')->middleware('coordinator');
Route::post('/coordinator_company-store', [CompanyController::class, 'storeCompany'])->name('coordinator.company_store');

Route::get('/coordinator_company-edit/{company}', [CompanyController::class, 'editCompany'])->name('coordinator.company_edit')->middleware('coordinator');
Route::put('/coordinator_company-update/{company}', [CompanyController::class, 'updateCompany'])->name('coordinator.company_update');

Route::get('coordinator_company-list', [CompanyController::class, 'getCompany'])->name('coordinator_company-list');
Route::get('coordinator_company-page', [CompanyController::class, 'getCompany'])->name('coordinator_company-page');

Route::get('/coordinator/company/{id}', [CompanyController::class, 'companyInfo'])->name('coordinator_company_info');

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

Route::get('/coordinator_student-list/{students}/edit', [CoordinatorUserController::class, 'edit'])->name('coordinator_student-list.edit')->middleware('coordinator'); // COORDINATOR EDIT STUDENT

Route::put('/coordinator_student-list/{students}/update', [CoordinatorUserController::class, 'update'])->name('coordinator_student-list.update')->middleware('coordinator'); // COORDINATOR UPDATE STUDENT

Route::post('/coordinator_student-list/students/{id}/toggle-status', [CoordinatorUserController::class, 'toggleStatus'])->name('coordinator_student-list.toggleStatus')->middleware('coordinator');

Route::post('/removeMatchedCompanies', [StudentController::class, 'removeMatchedCompanies'])->name('student.remove-matched-company');
/*
|----------------------------------------------------------------
| Dashboard Controller                                          |
|---------------------------------------------------------------|
| All Functions in Dashboard Controller                         |
|----------------------------------------------------------------
*/
Route::get('/coordinator', [DashboardController::class, 'getCoordinatorDashboardData'])->name('coordinator')->middleware('coordinator');

Route::get('/student', [DashboardController::class, 'getStudentDashboardData'])->name('student')->middleware('student');

Route::get('/admin', [DashboardController::class, 'getAdminDashboardData'])->name('admin')->middleware('admin');

/*
|----------------------------------------------------------------
| Journal Controller                                            |
|---------------------------------------------------------------|
| All Functions in Journalr Controller                          |
|----------------------------------------------------------------
*/
Route::get('/journal',  [JournalController::class, 'journalStudent'])->name('student_journal');

Route::get('/coordinator_student-journal', [JournalController::class, 'journalCoordinator'])->name('coordinator_student-journal');

Route::get('/journal/create',  [JournalController::class, 'createJournal'])->name('create_journal')->middleware('student');

Route::post('/journal/store',  [JournalController::class, 'storeJournal'])->name('store_journal');

Route::get('/edit-journal/{journal}', [JournalController::class, 'editJournal'])->name('edit_journal');

Route::put('/update-journal/{journalID}', [JournalController::class, 'updateJournal'])->name('update_journal');

Route::get('/coordinator/student-journal-grade/{journal}', [JournalController::class, 'studentJournalGrade'])->name('student.journal.grade')->middleware('coordinator');

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

Route::get('/student-profile', [StudentController::class, 'journalRenderedHours'])->name('student_profile')->middleware('student');

Route::get('/company-list', [StudentController::class, 'displayCompany'])->name('student_company-list');

Route::get('/matched-company', [StudentController::class, 'displayMatchedCompany'])->name('matched.company.list');

Route::get('/profile/edit/', [StudentController::class, 'editProfile'])->name('profile.edit')->middleware('student');

Route::put('/profile/update', [StudentController::class, 'updateProfile'])->name('profile.update');

Route::get('/password/edit/', [StudentController::class, 'editPassword'])->name('password.edit');

Route::put('/password/update', [StudentController::class, 'updatePassword'])->name('password.update');

Route::get('/profile', [StudentController::class, 'journalRenderedHours'])->name('profile');

Route::get('/coordinator/student-list', [StudentController::class, 'studentHiredCompany'])->name('coordinator.student-list');

Route::post('/removeStudentPosition', [StudentController::class, 'removePositions'])->name('student.remove-positions');

Route::post('/add-supervisor', [StudentController::class, 'addSupervisor'])->name('add.supervisor');

Route::get('/student/company/{id}', [StudentController::class, 'companyInformation'])->name('student_company_information')->middleware('student');

/*
|----------------------------------------------------------------
| Admin Controller                                              |
|---------------------------------------------------------------|
| All Functions in Admin Controller                             |
|----------------------------------------------------------------
*/
Route::get('/admin_company-list', [AdminController::class, 'companyAdmin'])->name('admin_company-page')->middleware('admin');

Route::get('/admin_coordinator-list', [AdminController::class, 'coordinatorList'])->name('admin_coordinator-page')->middleware('admin');

Route::get('/admin_student-list', [AdminController::class, 'studentList'])->name('admin_student-page')->middleware('admin');

Route::get('/admin_create', [AdminController::class, 'createCoordinator'])->name('admin-coordinator_create')->middleware('admin');

Route::post('/admin_store', [AdminController::class, 'storeCoordinator'])->name('admin-coordinator_store');

Route::get('/admin_coordinator/{user}/edit', [AdminController::class, 'editCoordinator'])->name('admin-coordinator_edit');

Route::put('/admin/coordinator/{user}/update',  [AdminController::class, 'updateCoordinator'])->name('admin-coordinator_update');




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

Route::get('/coordinator-profile', [ExportReportController::class, 'journalGrade'])->name('coordinator_profile')->middleware('coordinator');

Route::get('/export-journal-grades', [ExportReportController::class, 'exportJournalGrades'])->name('export.journal.grades');

/*
|----------------------------------------------------------------
|   Import Report Controller                                    |
|---------------------------------------------------------------|
| All Routes for ExportReportController                         |
|----------------------------------------------------------------
*/
Route::get('/student-list-bulk', [ImportController::class, 'redirectToStudentBulkList'])->name('student_bulk_list')->middleware('coordinator');

Route::get('/company-list-bulk', [ImportController::class, 'redirectToCompanyBulkList'])->name('company_bulk_list')->middleware('coordinator');

Route::post('/import', [ImportController::class, 'import'])->name('import');

Route::post('/importCompany', [ImportController::class, 'importCompany'])->name('import_company');

/*
|----------------------------------------------------------------
|   Forget Password Controller                                  |
|---------------------------------------------------------------|
| All Routes for ExportReportController                         |
|----------------------------------------------------------------
*/
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('forget.password');

Route::post('/forgot-password', [ForgotPasswordController::class, 'forgetPasswordPost'])->name('forget.password.post');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('reset.password');

Route::post('/reset-password', [ForgotPasswordController::class, 'resetPasswordPost'])->name('reset.password.post');
