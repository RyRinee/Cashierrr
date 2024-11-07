<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'signinview')->name('login');
    Route::post('/login', 'authenticate')->name('login');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admindash', function () {
        return view('dashboard.admin');
    })->name('admindash');
    Route::get('/productlist', function () {
        return view('product.list');
    })->name('productlist');
    Route::get('/employeeList', function () {
        return view('employee.index');
    })->name('employeeList');
});