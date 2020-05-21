<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function __construct()
    {
        // Общее для всех котроллеров магазина - закладываем базу для роста
    }
}
