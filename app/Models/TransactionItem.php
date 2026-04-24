<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    //
    protected $fillable = [
        'qty',
        'amount',
        'selling_price',   
        'cost_price',   
        'profit',
        'transaction_id',
        'product_id',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
