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
<<<<<<< HEAD
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
=======
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/employeeList', 'index')->name('employeeList');
        Route::get('/addEmployee', 'create')->name('addEmployee');
        Route::post('/createEmployee', 'store')->name('createEmployee');
        Route::get('/editEmployee/{id}', 'edit')->name('editEmployee');
        Route::post('/updateEmployee/{id}', 'update')->name('updateEmployee');
        Route::delete('/deleteEmployee/{id}', 'destroy')->name('deleteEmployee');
>>>>>>> 43b863dd625809f851feb0ce3a26c4acbb18d73e
    });
});


Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employeeDash', function () {
        return view('employee.dashboard');
    })->name('employeeDash');
});


Route::middleware(['auth', 'role:delivery'])->group(function () {});
Route::middleware(['auth', 'role:customer'])->group(function () {});
