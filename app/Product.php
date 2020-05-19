<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function order()
    {
        return $this->belongsToMany(Order::class, 'order_products');
    }
}
