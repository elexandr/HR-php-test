<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable
        = [
            'client_email',
            'status',
        ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }


    public function orderproduct()
    {
        return$this->hasMany(OrderProduct::class);
    }


   public function product()
    {
        return $this->belongsToMany(Product::class, 'order_products');
    }

}
