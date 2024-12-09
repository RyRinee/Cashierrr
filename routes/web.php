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
    Route::get('/menuListAdmin', [MenuController::class, 'indexAdmin'])->name('menuListAdmin');
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/employeeList', 'index')->name('employeeList');
        Route::get('/addEmployee', 'create')->name('addEmployee');
        Route::post('/createEmployee', 'store')->name('createEmployee');
        Route::get('/editEmployee/{id}', 'edit')->name('editEmployee');
        Route::post('/updateEmployee/{id}', 'update')->name('updateEmployee');
        Route::delete('/deleteEmployee/{id}', 'destroy')->name('deleteEmployee');
        Route::get('/employee/export', [MenuController::class, 'export'])->name('employee.export');
    });
    Route::controller(TransactionController::class)->group(function () {
        Route::get('/transactionDetails', 'transactions')->name('transactionDetails');
        Route::get('/transactionEdit/{id}', 'edit')->name('transactionEdit');
        Route::post('/transactionUpdate/{id}', 'update')->name('transactionUpdate');
        Route::delete('/deleteTransactions/{id}', 'destroy')->name('deleteTransactions');
        Route::get('/transaction/export', [MenuController::class, 'export'])->name('transaction.export');
        Route::get('/rekap', 'recapitulate')->name('rekap');
        Route::get('/rekap/export', 'exportRekap')->name('transaction.exportRekap');

    });

});

Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/menuList', [MenuController::class, 'index'])->name('menuList');
    Route::get('/addMenu', [MenuController::class, 'create'])->name('addMenu');
    Route::post('/createMenu', [MenuController::class, 'store'])->name('createMenu');
    Route::get('/editMenu/{id}', [MenuController::class, 'edit'])->name('editMenu');
    Route::post('/updateMenu/{id}', [MenuController::class, 'update'])->name('updateMenu');
    Route::delete('/deleteMenu/{id}', [MenuController::class, 'destroy'])->name('deleteMenu');
    Route::get('/menu/export', [MenuController::class, 'export'])->name('menu.export');

});


Route::middleware(['auth', 'role:cashier'])->group(function () {
    Route::get('/order', [TransactionController::class, 'create'])->name('order');
    Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction');
    Route::get('/transaction/struk/{id}', [TransactionController::class, 'showStruk'])->name('struk');

});
