<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sales.transaction');
    }

    public function transactions () {
        $transactions = Transaction::with('details', 'user', 'menu')->get();
        return view('transactions.details', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = Menu::all();
        return view('sales.order', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang dikirim dari form
        $request->validate([
            'payment_method_option' => 'required|string', // Validasi untuk metode pembayaran
            'cash_amount' => 'required_if:payment_method_option,Cash|numeric|min:1', // Validasi jumlah uang jika metode pembayaran adalah Cash
            'total_amount' => 'required|numeric|min:1', // Total harus ada dan lebih dari 0
            'cart_items' => 'required|json', // Validasi item keranjang harus dalam format JSON
        ]);
    
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['date'] = now()->toDateString();
    
        // Buat transaksi baru
        $transaction = new Transaction();
        $transaction->user_id = $input['user_id'];
        $transaction->date = $input['date'];
        $transaction->total_amount = $input['total_amount'];
        $transaction->payment_method = $input['payment_method_option'];
    
        if ($input['payment_method_option'] === 'Cash') {
            $transaction->cash_amount = $input['cash_amount'];
        } else {
            $transaction->cash_amount = 0; // Atur cash_amount ke 0 untuk metode pembayaran selain Cash
        }
        
        $transaction->save();
    
        // Decode JSON cart_items ke array
        $cartItems = json_decode($input['cart_items'], true);
    
        // Simpan detail item
        foreach ($cartItems as $item) {
            $menu = Menu::where('name', $item['name'])->firstOrFail();
            $hargaMenu = $menu->price;
    
            $subtotal = $hargaMenu * $item['quantity'];
    
            // Simpan detail transaksi
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'menu_id' => $menu->id,
                'quantity' => $item['quantity'],
                'price' => $hargaMenu,
                'subtotal' => $subtotal,
            ]);
        }
    
        // Redirect ke halaman struk
        return redirect()->route('struk', ['id' => $transaction->id, 'payment_amount' => $input['cash_amount'] ?? $input['total_amount']]);
    }
    


    public function showStruk($id, Request $request)
    {
        $transaction = Transaction::with('details.menu')->findOrFail($id);

        return view('sales.struk', [
            'transaction' => $transaction,
            'payment_amount' => $request->input('payment_amount')
        ]);
    }

    


    /**
     * Display the specified resource.
     */
    public function show(Transaction $transactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
