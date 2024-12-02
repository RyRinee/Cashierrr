<?php

namespace App\Exports;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Mengambil data transaksi dan detailnya
        $transactions = Transaction::with('details')->get();
        
        $data = [];
        
        // Menggabungkan data transaksi dengan detail transaksi dalam satu array
        foreach ($transactions as $transaction) {
            foreach ($transaction->details as $detail) {
                $data[] = [
                    'transaction_id' => $transaction->id,
                    'user_id' => $transaction->user_id,
                    'date' => $transaction->date,
                    'total_amount' => $transaction->total_amount,
                    'cash_amount' => $transaction->cash_amount,
                    'payment_method' => $transaction->payment_method,
                    'status' => $transaction->status,
                    'menu_name' => $detail->menu->name, // Asumsi relasi antara TransactionDetail dan Menu
                    'quantity' => $detail->quantity,
                    'price' => $detail->price,
                    'subtotal' => $detail->subtotal,
                ];
            }
        }

        return collect($data);  // Mengembalikan data dalam bentuk collection
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Transaction ID',
            'User ID',
            'Date',
            'Total Amount',
            'Cash Amount',
            'Payment Method',
            'Status',
            'Menu Name',
            'Quantity',
            'Price',
            'Subtotal',
        ];
    }
}
