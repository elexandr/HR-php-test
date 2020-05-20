<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'price',
    ];

    public function order()
    {
        return $this->belongsToMany(Order::class, 'order_products');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
