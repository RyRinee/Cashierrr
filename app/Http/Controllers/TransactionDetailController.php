<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = TransactionDetail::all();
        return view('transaction.detail', compact('details'));
    }

    public function edit($id)
    {
        $details = TransactionDetail::find($id);
        return view('transaction.edit', compact('details'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransactionDetail $transactionDetail)
    {
        // Validasi data input
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // Update data transaction detail
        $transactionDetail->update([
            'transaction_id' => $request->transaction_id,
            'menu_id' => $request->menu_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'subtotal' => $request->quantity * $request->price,
        ]);

        return redirect()->route('transaction.details')->with('success', 'Transaction detail updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionDetail $transactionDetail)
    {
        // Hapus data transaction detail
        $transactionDetail->delete();
        return redirect()->route('transaction.details')->with('success', 'Transaction detail deleted successfully');
    }
}
