<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    //
    protected $fillable = [
        'product_id',
        'qty',
        'remaining_qty',
        'expired_date',
        'note',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
