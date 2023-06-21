<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\RoleConroller;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admins\BankController;
use App\Http\Controllers\Admins\UserController;
use App\Http\Controllers\Admins\TaxesController;
use App\Http\Controllers\Admins\BranchController;
use App\Http\Controllers\Admins\AddressController;
use App\Http\Controllers\Admins\HolidayController;
use App\Http\Controllers\Admins\SettingController;
use App\Http\Controllers\Admins\TrainerController;
use App\Http\Controllers\Admins\DashboadController;
use App\Http\Controllers\Admins\EmployeeController;
use App\Http\Controllers\Admins\PositionController;
use App\Http\Controllers\Admins\ProvinceController;
use App\Http\Controllers\Admins\TrainingController;
use App\Http\Controllers\Admins\DepartmentController;
use App\Http\Controllers\Admins\PermissionController;
use App\Http\Controllers\Admins\LeavesAdminController;
use App\Http\Controllers\Admins\MotorRentelController;
use App\Http\Controllers\Admins\ExchangeRateController;
use App\Http\Controllers\Admins\TrainingTypeController;
use App\Http\Controllers\Admins\PayrollReportController;
use App\Http\Controllers\Admins\EmployeeReportController;
use App\Http\Controllers\Admins\LeavesEmployeeController;
use App\Http\Controllers\Admins\AttendanceAdminController;
use App\Http\Controllers\Admins\EmployeePayrollController;
use App\Http\Controllers\Admins\EmployeeProfileController;
use App\Http\Controllers\Admins\AttendanceEmployeeController;
use App\Http\Controllers\Admins\CandidateResumeController;
use App\Http\Controllers\Admins\RecruitmentPlanController;
use App\Http\Controllers\Admins\ReportsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::post('/login', [LoginController::class, 'login']);
Auth::routes();
Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/dashboad/employee', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboad.employee');
    Route::get('/dashboad/employee', [DashboadController::class, 'dashboadEmployee']);
    Route::get('/dashboad/admin', [DashboadController::class, 'dashboadAdmin']);
    Route::get('/dashboad/show', [DashboadController::class, 'show']);

    Route::get('/employee/profile/{id}', [EmployeeProfileController::class, 'employeeProfile'])->name('employee.profile');
    Route::post('employee/education', [EmployeeProfileController::class, 'employeeEducation'])->name('employee.education');
    Route::post('employee/experience', [EmployeeProfileController::class, 'updateOrCreateExperience'])->name('employee.experience');
    Route::post('employee/promote', [EmployeeProfileController::class, 'updateOrCreatePromote'])->name('employee.promote');
    Route::post('employee/transferred', [EmployeeProfileController::class, 'updatedTransferred'])->name('employee.transferred');
    Route::post('employee/training', [EmployeeProfileController::class, 'updatedTraining'])->name('employee.training');
    Route::post('employee/contact', [EmployeeProfileController::class, 'employeeContact'])->name('employee.contact');
    Route::post('employee/children', [EmployeeProfileController::class, 'employeeChildren'])->name('employee.children');
    Route::get('employee/children/edit', [EmployeeProfileController::class, 'editChildrenInformation']);
    Route::post('employee/children/update', [EmployeeProfileController::class, 'childrenUpdate']);
    Route::get('/holidays', [HolidayController::class, 'index']);
    Route::post('/holidays/create', [HolidayController::class, 'store']);
    Route::get('/holidays/edit', [HolidayController::class, 'edit']);
    Route::post('/holidays/update', [HolidayController::class, 'update']);
    // Route::get('/attendance/admin', [AttendanceAdminController::class, 'index']);
    // Route::get('/attendance/employee', [AttendanceEmployeeController::class, 'index']);
    // Route::Resource('/leaves/admin', LeavesAdminController::class);
    Route::get('/leaves/employee', [LeavesEmployeeController::class,'index']);
    Route::get('/employee/report',[EmployeeReportController::class,'index']);
    Route::post('employee/report',[EmployeeReportController::class,'index']);

    Route::get('role', [RoleConroller::class,'index']);
    Route::post('role/store', [RoleConroller::class,'store']);
    Route::post('role/update', [RoleConroller::class,'update']);
    Route::post('role/delete', [RoleConroller::class,'destroy']);
    Route::Resource('permission', PermissionController::class);

    Route::get('/department', [DepartmentController::class,'index']);
    Route::post('/department/store', [DepartmentController::class,'store']);
    Route::post('/department/delete', [DepartmentController::class,'destroy']);
    Route::post('/department/update', [DepartmentController::class,'update']);

    Route::get('/position', [PositionController::class,'index']);
    Route::post('/position/store', [PositionController::class,'store']);
    Route::post('/position/update', [PositionController::class,'update']);
    Route::post('/position/delete', [PositionController::class,'destroy']);

    Route::get('/branch', [BranchController::class,'index']);
    Route::post('/branch/store', [BranchController::class,'store']);
    Route::post('/branch/delete', [BranchController::class,'destroy']);
    Route::post('/branch/update', [BranchController::class,'update']);

    // users
    Route::get('users', [UserController::class,'index']);
    Route::post('users', [UserController::class,'index']);
    Route::post('users/store', [UserController::class,'store']);
    Route::post('users/update', [UserController::class,'update']);
    Route::post('users/delete', [UserController::class,'destroy']);
    Route::get('users/edit', [UserController::class,'edit']);
    Route::post('/employee/status', [UserController::class,'processing']);
    Route::get('users/reasonoption', [UserController::class, 'reasonOption']);
    Route::get('users/birthday', [UserController::class, 'showDetailBirthday']);

    //Employee Payroll
    Route::get('payroll',[EmployeePayrollController::class,'index']);
    Route::get('motor-rentel/list',[MotorRentelController::class,'index']);
    Route::get('motor-rentel/edit',[MotorRentelController::class,'edit']);
    Route::get('motor-rentel/detail/{id}',[MotorRentelController::class,'detail']);
    Route::post('motor-rentel/store',[MotorRentelController::class,'store']);
    Route::post('motor-rentel/update',[MotorRentelController::class,'update']);
    Route::post('motor-rentel/delete',[MotorRentelController::class,'destroy']);
    Route::post('motor-rentel/list',[MotorRentelController::class,'index']);

    Route::post('payroll/store',[EmployeePayrollController::class,'store']);
    Route::get('payslip/{employee_id}',[EmployeePayrollController::class,'paySlip']);

    // route province
    Route::get('province', [ProvinceController::class,'index']);
    Route::post('district', [ProvinceController::class,'showDistrict']);
    Route::post('commune', [ProvinceController::class,'showCommune']);
    Route::post('village', [ProvinceController::class,'showVillage']);
    
    // route banks
    Route::get('/bank', [BankController::class,'index']);
    Route::post('/bank/store', [BankController::class,'store']);
    Route::post('/bank/update', [BankController::class,'update']);
    Route::post('/bank/delete', [BankController::class,'destroy']);

    // route Taxes
    Route::get('/taxes', [TaxesController::class,'index']);
    Route::post('/taxes/store', [TaxesController::class,'store']);
    Route::post('/taxes/update', [TaxesController::class,'update']);
    Route::post('/taxes/delete', [TaxesController::class,'destroy']);
    Route::post('/taxes/status', [TaxesController::class,'processing']);

    // route trainings
    Route::get('/training/list', [TrainingController::class,'index']);
    Route::get('/training/trainer', [TrainingController::class,'trainer']);
    Route::post('/training/store', [TrainingController::class,'store']);
    Route::post('/training/update', [TrainingController::class,'update']);
    Route::get('/training/edit', [TrainingController::class,'edit']);
    Route::post('/training/delete', [TrainingController::class,'destroy']);
    Route::post('/training/status', [TrainingController::class,'processing']);
    Route::get('/training/detail/{id}', [TrainingController::class,'detail']);

    // route trainer
    Route::get('/trainer/list', [TrainerController::class,'index']);
    Route::post('/trainer/store', [TrainerController::class,'store']);
    Route::get('/trainer/edit', [TrainerController::class,'edit']);
    Route::post('/trainer/update', [TrainerController::class,'update']);
    Route::post('/trainer/delete', [TrainerController::class,'destroy']);
    Route::post('/trainer/status', [TrainerController::class,'processing']);

    // route trainings type
    Route::get('/training-type/list', [TrainingTypeController::class,'index']);
    Route::post('/training-type/store', [TrainingTypeController::class,'store']);
    Route::post('/training-type/update', [TrainingTypeController::class,'update']);
    Route::post('/training-type/delete', [TrainingTypeController::class,'destroy']);
    Route::post('/training-type/status', [TrainingTypeController::class,'processing']);

    // route exchange rate
    Route::get('/exchange-rate/list', [ExchangeRateController::class,'index']);
    Route::post('/exchange-rate/store', [ExchangeRateController::class,'store']);
    Route::post('/exchange-rate/update', [ExchangeRateController::class,'update']);
    Route::post('/exchange-rate/delete', [ExchangeRateController::class,'destroy']);
    Route::post('/exchange-rate/status', [ExchangeRateController::class,'processing']);

    // route block reports
    Route::get('/reports/payroll-report', [PayrollReportController::class,'index']);
    Route::get('/reports/motor-rentel-report', [PayrollReportController::class,'motorrentel']);
    Route::post('/reports/motor-rentel-report', [PayrollReportController::class,'motorrentel']);
    Route::get('/reports/new_staff-report', [ReportsController::class,'newStaff']);
    Route::post('/reports/new_staff-report', [ReportsController::class,'newStaff']);
    Route::get('/reports/staff-resigned-report', [ReportsController::class,'staffResigned']);
    Route::post('/reports/staff-resigned-report', [ReportsController::class,'staffResigned']);
    Route::get('/reports/promoted-staff-report', [ReportsController::class,'staffPromoted']);
    Route::post('/reports/promoted-staff-report', [ReportsController::class,'staffPromoted']);
    Route::get('/reports/transferred-staff-report', [ReportsController::class,'staffTransferred']);
    Route::post('/reports/transferred-staff-report', [ReportsController::class,'staffTransferred']);
    
    // test export excel
    Route::get('motor-rentel/export',[PayrollReportController::class,'export']);
    Route::post('motor-rentel/import',[MotorRentelController::class,'import']);

    //change password
    Route::get('change/password',[SettingController::class,'changePassword']);
    Route::post('update/password',[SettingController::class,'updatePassword']);

    // route block recruitment
    Route::get('/recruitment/plan-list', [RecruitmentPlanController::class,'index']);
    Route::post('/recruitment/plan-store', [RecruitmentPlanController::class,'store']);
    Route::post('/recruitment/plan-update', [RecruitmentPlanController::class,'update']);
    Route::post('/recruitment/plan-delete', [RecruitmentPlanController::class,'destroy']);
    Route::get('/recruitment/plan-edit', [RecruitmentPlanController::class,'edit']);
    // route block recruitment candidate resume
    Route::get('/recruitment/candidate-resume/list', [CandidateResumeController::class,'index']);
    Route::get('/recruitment/candidate-resume/show', [CandidateResumeController::class,'show']);
    Route::post('/recruitment/candidate-resume/store', [CandidateResumeController::class,'store']);
    Route::get('/recruitment/candidate-resume/edit', [CandidateResumeController::class,'edit']);
    Route::post('/recruitment/candidate-resume/update', [CandidateResumeController::class,'update']);
    Route::post('/recruitment/candidate-resume/status', [CandidateResumeController::class,'processing']);
    Route::post('/recruitment/candidate-resume/delete', [CandidateResumeController::class,'destroy']);
});