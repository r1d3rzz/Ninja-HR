<?php

use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes(["register" => false]);

Route::middleware('auth')->group(function () {
    Route::get("/", [PageController::class, 'home'])->name('home');
    Route::resource('employees', EmployeeController::class);
    Route::get("/employee/database/ssd", [EmployeeController::class, "ssd"])->name("employees.dbtable");

    Route::resource('departments', DepartmentController::class);

    Route::resource('roles', RoleController::class);

    Route::resource('permissions', PermissionController::class);

    Route::get("/profile", [ProfileController::class, 'profile'])->name('profile.profile');

    Route::resource("/company_settings", CompanySettingController::class)->only(['show', 'edit', 'update']);
});
