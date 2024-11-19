<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MenuController;
use App\Models\Employee;



Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'signinview')->name('login');
    Route::post('/login', 'authenticate')->name('loginProses');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/adminDash', function () {
        return view('dashboard.admin');
    })->name('adminDash');
    Route::controller(MenuController::class)->group(function () {
        Route::get('/menuList', 'index')->name('menuList');
        Route::get('/addMenu', 'create')->name('addMenu');
        Route::post('/createMenu', 'store')->name('createMenu');
        Route::get('/editMenu/{menu}', 'edit')->name('editMenu');
        Route::post('/updateMenu/{menu}', 'update')->name('updateMenu');
        Route::delete('/deleteMenu/{menu}', 'destroy')->name('deleteMenu');
    });
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/employeeList', 'index')->name('employeeList');
        Route::get('/addEmployee', 'create')->name('addEmployee');
        Route::post('/createEmployee', 'store')->name('createEmployee');
        Route::get('/editEmployee/{id}', 'edit')->name('editEmployee');
        Route::post('/updateEmployee/{id}', 'update')->name('updateEmployee');
        Route::delete('/deleteEmployee/{id}', 'destroy')->name('deleteEmployee');
    });

});


Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employeeDash', function () {
        return view('employee.dashboard');
    })->name('employeeDash');
    Route::get('/order', [MenuController::class, 'show'])->name('order');
});


Route::middleware(['auth', 'role:delivery'])->group(function () {});
Route::middleware(['auth', 'role:customer'])->group(function () {});
