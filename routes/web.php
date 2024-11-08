<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MenuController;
use App\Models\Employee;



Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'signinview')->name('login');
    Route::post('/login', 'authenticate')->name('login');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/adminDash', function () {
        return view('dashboard.admin');
    })->name('adminDash');
    Route::controller(MenuController::class)->group(function () {
        Route::get('/menuList', 'index')->name('menuList');
        Route::get('/menuAdd', 'create')->name('menuAdd');
        Route::post('/createMenu', 'store')->name('createMenu');
    });
    Route::get('/employeeList', function () {
        return view('employee.list');
    })->name('employeeList');
    Route::get('/addEmployee', function () {
        return view('employee.addEmployee');
    })->name('addEmployee');
});


Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employeeDash', function () {
        return view('employee.dashboard');
    })->name('employeeDash');
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/employeeList', 'index')->name('employeeList');
        Route::get('/addEmployee', 'create')->name('addEmployee');
        Route::get('/editEmployee', 'store')->name('editEmployee');
    });
});


Route::middleware(['auth', 'role:delivery'])->group(function () {});
Route::middleware(['auth', 'role:customer'])->group(function () {});
