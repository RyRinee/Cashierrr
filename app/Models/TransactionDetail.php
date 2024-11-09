<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    public function Transaction()
{
    return $this->belongsTo(Transaction::class);
}

public function menu()
{
    return $this->belongsTo(Menu::class);
}
}