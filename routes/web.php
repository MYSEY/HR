<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\UserController;
use App\Http\Controllers\Admins\BranchController;
use App\Http\Controllers\Admins\AddressController;
use App\Http\Controllers\Admins\HolidayController;
use App\Http\Controllers\Admins\DashboadController;
use App\Http\Controllers\Admins\EmployeeController;
use App\Http\Controllers\Admins\PositionController;
use App\Http\Controllers\Admins\DepartmentController;
use App\Http\Controllers\Admins\LeavesAdminController;
use App\Http\Controllers\Admins\RolePermissionConroller;
use App\Http\Controllers\Admins\LeavesEmployeeController;
use App\Http\Controllers\Admins\AttendanceAdminController;
use App\Http\Controllers\Admins\EmployeeProfileController;
use App\Http\Controllers\Admins\AttendanceEmployeeController;

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
// Route::get('/', function () {
//     return view('layouts.master');
// });

Auth::routes();

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/dashboad/employee', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboad.employee');
    Route::get('address', [AddressController::class,'index'])->name('address');
    Route::get('permanent/address', [AddressController::class,'permanentAddress'])->name('permanent.address');
    Route::get('/dashboad/employee', [DashboadController::class, 'dashboadEmployee']);
    Route::get('/dashboad/admin', [DashboadController::class, 'dashboadAdmin']);
    Route::get('/employee/profile/{id}', [EmployeeProfileController::class, 'employeeProfile'])->name('employee.profile');
    Route::post('employee/education', [EmployeeProfileController::class, 'employeeEducation'])->name('employee.education');
    Route::post('employee/experience', [EmployeeProfileController::class, 'updateOrCreateExperience'])->name('employee.experience');
    Route::post('employee/promote', [EmployeeProfileController::class, 'updateOrCreatePromote'])->name('employee.promote');
    // Route::get('/holidays', [HolidayController::class, 'index']);
    // Route::get('/attendance/admin', [AttendanceAdminController::class, 'index']);
    // Route::get('/attendance/employee', [AttendanceEmployeeController::class, 'index']);
    // Route::Resource('/leaves/admin', LeavesAdminController::class);
    // Route::Resource('/leaves/employee', LeavesEmployeeController::class);
    
    Route::Resource('employee', EmployeeController::class);
    Route::Resource('role-permission', RolePermissionConroller::class);

    Route::Resource('/department', DepartmentController::class);
    Route::Resource('/position', PositionController::class);
    Route::Resource('/branch', BranchController::class);
    Route::Resource('/users', UserController::class);
});