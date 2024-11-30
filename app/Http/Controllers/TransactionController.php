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
