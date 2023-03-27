<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\RoleConroller;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admins\UserController;
use App\Http\Controllers\Admins\BranchController;
use App\Http\Controllers\Admins\AddressController;
use App\Http\Controllers\Admins\HolidayController;
use App\Http\Controllers\Admins\DashboadController;
use App\Http\Controllers\Admins\EmployeeController;
use App\Http\Controllers\Admins\PositionController;
use App\Http\Controllers\Admins\DepartmentController;
use App\Http\Controllers\Admins\PermissionController;
use App\Http\Controllers\Admins\LeavesAdminController;
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
Route::post('/login', [LoginController::class, 'login']);
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
    Route::post('employee/transferred', [EmployeeProfileController::class, 'updatedTransferred'])->name('employee.transferred');
    Route::post('employee/training', [EmployeeProfileController::class, 'updatedTraining'])->name('employee.training');
    // Route::get('/holidays', [HolidayController::class, 'index']);
    // Route::get('/attendance/admin', [AttendanceAdminController::class, 'index']);
    // Route::get('/attendance/employee', [AttendanceEmployeeController::class, 'index']);
    // Route::Resource('/leaves/admin', LeavesAdminController::class);
    // Route::Resource('/leaves/employee', LeavesEmployeeController::class);
    
    // Route::Resource('employee', EmployeeController::class);
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
    Route::post('/position/delete', [PositionController::class,'destroy']);
    Route::post('/position/update', [PositionController::class,'destroy']);

    Route::get('/branch', [BranchController::class,'index']);
    Route::post('/branch/store', [BranchController::class,'store']);
    Route::post('/branch/delete', [BranchController::class,'destroy']);
    Route::post('/branch/update', [BranchController::class,'update']);

    Route::get('users', [UserController::class,'index']);
    Route::post('users/store', [UserController::class,'store']);
    Route::post('users/update', [UserController::class,'update']);
    Route::post('users/delete', [UserController::class,'destroy']);
    Route::get('users/edit', [UserController::class,'edit']);
    Route::post('employee/status', [UserController::class,'processing']);
});