<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MyPayrollController;
use App\Http\Controllers\MyProjectController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\MyAttendanceController;
use App\Http\Controllers\AttendanceScanController;
use App\Http\Controllers\CompanySettingController;

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

Auth::routes(["register" => !false]);

Route::middleware('auth')->group(function () {
    Route::get("/", [PageController::class, 'home'])->name('home');
    Route::resource('employees', EmployeeController::class);
    Route::get("/employee/database/ssd", [EmployeeController::class, "ssd"])->name("employees.dbtable");

    Route::resource('departments', DepartmentController::class);

    Route::resource('projects', ProjectController::class);

    Route::resource('salaries', SalaryController::class);

    Route::resource('roles', RoleController::class);

    Route::resource('permissions', PermissionController::class);

    Route::get("/profile", [ProfileController::class, 'profile'])->name('profile.profile');

    Route::resource("/company_settings", CompanySettingController::class)->only(['show', 'edit', 'update']);

    Route::resource('/attendance_scan', AttendanceScanController::class)->only(['index', 'store']);
});

Route::controller(AttendanceController::class)->group(function () {
    Route::get("/checkin-checkout", 'checkincheckoutHandler');
    Route::post("/checkin", 'checkIncheckOut');
    Route::get("/attendances", 'index')->name('attendances.index');
    Route::get("/attendances/create", 'create')->name('attendances.create');
    Route::post("/attendances", 'store');
    Route::get("/attendances/{attendance}/edit", 'edit')->name('attendances.edit');
    Route::put("/attendances/{attendance}", 'update')->name('attendances.update');
    Route::delete("/attendances/{attendance}", 'destroy')->name('attendances.destroy');
    Route::get("/attendances_overview", 'attendances_overview')->name('attendances.overview');
    Route::get("/attendances_overview_table", 'attendances_overview_table')->name('attendances.overview_table');
});

Route::controller(MyAttendanceController::class)->group(function () {
    Route::get("/my-attendances_overview_table/all", 'index')->name('my-attendances_overview_table.index');
    Route::get("/my-attendances_overview_table", 'my_attendances_overview_table');
});

Route::controller(MyPayrollController::class)->group(function () {
    Route::get("/my-payroll_table", 'my_payroll_table');
});

Route::resource('my-projects', MyProjectController::class)->only(['index', 'show']);

Route::controller(PayrollController::class)->group(function () {
    Route::get("/payroll", 'index')->name('payroll_table.index');
    Route::get("/payroll_table", 'payroll_table');
});
