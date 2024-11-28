<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionDetailController;
use App\Models\Employee;
use App\Models\TransactionDetail;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'signinview')->name('login');
    Route::post('/login', 'authenticate')->name('loginProses');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/adminDash', 'index')->name('adminDash');

});

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
    Route::controller(TransactionDetailController::class)->group(function () {
        Route::get('/transactionDetails', 'index')->name('transactionDetails');
        Route::get('/transactionEdit/{id}', 'edit')->name('transactionEdit');
        Route::post('/transactionUpdate/{id}', 'update')->name('transactionUpdate');
        Route::delete('/deleteTransactions/{id}', 'destroy')->name('deleteTransactions');
    });

});


Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/order', [TransactionController::class, 'create'])->name('order');
    // Route::get('/ordertest', function () {
    //     return view('sales.transaction');
    // })->name('order');
    Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction');
    Route::get('/transaction/struk/{id}', [TransactionController::class, 'showStruk'])->name('struk');

});
