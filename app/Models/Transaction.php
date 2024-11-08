<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function user()
{
    return $this->belongsTo(User::class);
}

public function TransactionDetails()
{
    return $this->hasMany(TransactionDetail::class);
}
}
