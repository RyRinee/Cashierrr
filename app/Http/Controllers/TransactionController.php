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
    $request->validate([
        'qty' => 'required|array',
        'qty.*' => 'required|integer|min:1',
        'payment_amount' => 'required|numeric|min:1',
        'total_amount' => 'required|numeric|min:1',
        'cart_items' => 'required|json',
    ]);

    $input = $request->all();
    $input['user_id'] = Auth::user()->id;
    $input['date'] = now()->toDateString();

    // Buat transaksi baru
    $transaction = new Transaction();
    $transaction->user_id = $input['user_id'];
    $transaction->date = $input['date'];
    $transaction->total_amount = $input['total_amount'];
    $transaction->save();
    
    $cartItems = json_decode($input['cart_items'], true);

    foreach ($input['qty'] as $menuId => $quantity) {
        $menu = Menu::findOrFail($menuId);
        $hargaMenu = $menu->price;

        $subtotal = $hargaMenu * $quantity;

        // Simpan detail transaksi
        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'menu_id' => $menuId,
            'quantity' => $quantity,
            'price' => $hargaMenu,
            'subtotal' => $subtotal,
        ]);
    }

    // Redirect ke halaman struk atau berhasil
    return redirect(route('struk', ['transaction' => $transaction->id, 'payment_amount' => $input['payment_amount']]));
}


    public function struk($id)
    {
        $transaction = Transaction::with('user')->find($id);
        return view('sales.struk', [
            'transaction' => $transaction
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
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
