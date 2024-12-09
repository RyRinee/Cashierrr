<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Exports\TransactionExport;
use App\Exports\RekapExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sales.transaction');
    }

    public function transactions(Request $request)
    {
        // Menambahkan filter pencarian jika ada input 'search'
        $transactions = Transaction::with('details', 'user', 'menu')
            ->when($request->search, function ($query) use ($request) {
                return $query->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('details', function ($q) use ($request) {
                    $q->whereHas('menu', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('category', 'like', '%' . $request->search . '%');
                    });
                });
            })
            ->when($request->filter, function ($query) use ($request) {
                $filter = $request->filter;
    
                // Filter per hari (misalnya hari ini)
                if ($filter == 'day') {
                    return $query->whereDate('date', Carbon::today());
                }
                // Filter per minggu (misalnya minggu ini)
                elseif ($filter == 'week') {
                    return $query->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                }
                // Filter per bulan (misalnya bulan ini)
                elseif ($filter == 'month') {
                    return $query->whereMonth('date', Carbon::now()->month);
                }
            })
            ->get();
    
        return view('transactions.details', compact('transactions'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $menus = Menu::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('category', 'like', '%' . $request->search . '%');
            })
            ->get();
        
        return view('sales.order', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang dikirim dari form
        $request->validate([
            'payment_method_option' => 'required|string',
            'cash_amount' => 'required_if:payment_method_option,Cash|numeric|min:1',
            'total_amount' => 'required|numeric|min:1',
            'cart_items' => 'required|json',
        ]);

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['date'] = now()->toDateString();
        $input['status'] = 'masuk';

        // Buat transaksi baru
        $transaction = new Transaction();
        $transaction->user_id = $input['user_id'];
        $transaction->date = $input['date'];
        $transaction->total_amount = $input['total_amount'];
        $transaction->payment_method = $input['payment_method_option'];
        $transaction->status = $input['status'];

        if ($input['payment_method_option'] === 'Cash') {
            $transaction->cash_amount = $input['cash_amount'];
        } else {
            $transaction->cash_amount = 0;
        }

        $transaction->save();

        // Decode JSON cart_items ke array
        $cartItems = json_decode($input['cart_items'], true);

        foreach ($cartItems as $item) {
            $product = Menu::where('name', $item['name'])->firstOrFail(); // Ambil produk
            $hargaMenu = $product->price;
            $subtotal = $hargaMenu * $item['quantity'];

            // Simpan detail transaksi
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'menu_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $hargaMenu,
                'subtotal' => $subtotal,
            ]);

            // Kurangi stok produk
            if ($product->stock < $item['quantity']) {
                throw new \Exception('Stok tidak mencukupi untuk ' . $product->name);
            }
            $product->stock -= $item['quantity'];
            $product->save();
        }

        return redirect()->route('struk', [
            'id' => $transaction->id,
            'payment_amount' => $input['cash_amount'] ?? $input['total_amount'],
        ]);
    }




    public function showStruk($id, Request $request)
    {
        $transaction = Transaction::with('details.menu')->findOrFail($id);

        return view('sales.struk', [
            'transaction' => $transaction,
            'payment_amount' => $request->input('payment_amount')
        ]);
    }

    


    public function export()
    {
        return Excel::download(new MenuExport, 'transaction_data.xlsx');
    }

    public function recapitulate(Request $request)
    {
        // Ambil tahun dan bulan yang difilter
        $year = $request->year ?? now()->year;
        $month = $request->month;
        $dayOrWeek = $request->day_or_week;
        $day = $request->day;
        $week = $request->week;

        $query = Transaction::query();

        // Filter berdasarkan tahun
        $query->whereYear('date', $year);

        // Filter berdasarkan bulan
        if ($month) {
            $query->whereMonth('date', $month);
        }

        // Filter berdasarkan hari
        if ($dayOrWeek == 'day' && $day) {
            $query->whereDate('date', Carbon::parse($day));
        }

        // Filter berdasarkan minggu
        if ($dayOrWeek == 'week' && $week) {
            $query->whereBetween('date', [
                Carbon::now()->setISODate($year, $week)->startOfWeek(),
                Carbon::now()->setISODate($year, $week)->endOfWeek(),
            ]);
        }

        // Ambil data transaksi
        $transactions = $query->get();

        // Rekap total transaksi per tanggal
        $recap = $transactions->groupBy(function ($transaction) {
            return Carbon::parse($transaction->date)->format('d-m-Y'); // Mengelompokkan berdasarkan tanggal (d-m-Y)
        });

        // Hitung total untuk setiap tanggal
        $recapTotals = $recap->map(function ($group) {
            return $group->sum('total_amount'); // Total transaksi untuk setiap tanggal
        });

        // Kirim data ke view
        return view('transactions.rekap', compact('recapTotals', 'transactions'));
    }
    
    

    public function exportRekap(Request $request)
    {
        // Ambil transaksi yang sudah difilter (misalnya berdasarkan tahun dan bulan)
        $query = Transaction::query();

        if ($request->has('year')) {
            $query->whereYear('date', $request->year);
        }

        if ($request->has('month')) {
            $query->whereMonth('date', $request->month);
        }

        // Kelompokkan transaksi berdasarkan tanggal dan hitung total per hari
        $transactions = $query->selectRaw('DATE(date) as date, SUM(total_amount) as total_amount')
            ->groupBy('date')
            ->get();

        // Ekspor data ke Excel
        return Excel::download(new RekapExport($transactions), 'rekap_transaksi.xlsx');
    }

}    

