<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Menu;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menghitung jumlah admin
        $adminCount = User::where('role', 'admin')->count();

        // Menghitung jumlah employees
        $employeeCount = User::where('role', 'employee')->count();

        // Menghitung jumlah transaksi masuk
        $transactionCount = Transaction::where('status', 'masuk')->count();

        $menus = Menu::all();

        // Kirim data ke view
        return view('dashboard.admin', compact('adminCount', 'employeeCount', 'transactionCount', 'menus'));
    }

}
