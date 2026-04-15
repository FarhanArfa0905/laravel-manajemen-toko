<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name',
        'price',
        'cost_price',
        'stock'
    ];

    public function stockIns()
    {
        return $this->hasMany(StockIn::class);
    }

    public function stockOuts()
    {
        return $this->hasMany(StockOut::class);
    }
}
