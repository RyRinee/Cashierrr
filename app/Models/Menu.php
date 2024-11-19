<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $fillable = ['name', 'category', 'price', 'stock', 'image', 'status'];

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
