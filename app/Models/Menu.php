<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function transactionDetails()
{
    return $this->hasMany(TransactionDetail::class);
}
}
