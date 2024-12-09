<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapExport implements FromCollection, WithHeadings
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * Ambil data yang akan diekspor
     */
    public function collection()
    {
        return $this->transactions->map(function ($transaction) {
            return [
                $transaction->date,          // Tanggal transaksi
                $transaction->total_amount,  // Total transaksi per hari
            ];
        });
    }

    /**
     * Judul kolom pada file Excel
     */
    public function headings(): array
    {
        return [
            'Tanggal',
            'Total Transaksi',
        ];
    }
}
