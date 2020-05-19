<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
