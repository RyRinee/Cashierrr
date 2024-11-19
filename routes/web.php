<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransactionDetailController;
use App\Models\Employee;
use App\Models\TransactionDetail;

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
        Route::get('/addMenu', 'create')->name('addMenu');
        Route::post('/createMenu', 'store')->name('createMenu');
        Route::get('/editMenu/{menu}', 'edit')->name('editMenu');
        Route::post('/updateMenu/{menu}', 'update')->name('updateMenu');
        Route::delete('/deleteMenu/{menu}', 'destroy')->name('deleteMenu');
    });
    Route::get('/employeeList', function () {
        return view('employee.list');
    })->name('employeeList');
    Route::get('/addEmployee', function () {
        return view('employee.addEmployee');
    })->name('addEmployee');

    Route::controller(TransactionDetailController::class)->group(function () {
        Route::get('/detailTransaction', 'index')->name('detailTransaction');
        Route::get('/editDetail{transactionDetail}', 'edit')->name('editDetail');
        Route::get('/destroyDetail{transactionDetail}', 'destroy')->name('destroyDetail');
    });
});


Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employeeDash', function () {
        return view('employee.dashboard');
    })->name('employeeDash');
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/employeeList', 'index')->name('employeeList');
        Route::get('/addEmployee', 'create')->name('addEmployee');
        Route::post('/createEmployee', 'store')->name('createEmployee');
        Route::get('/editEmployee/{employee}', 'store')->name('editEmployee');
        Route::post('/updateEmployee/{employee}', 'update')->name('updateEmployee');
        Route::delete('/deleteEmployee/{employee}', 'destroy')->name('deleteEmployee');
    });
});


Route::middleware(['auth', 'role:delivery'])->group(function () {});
Route::middleware(['auth', 'role:customer'])->group(function () {});
