<?php

namespace App\Http\Controllers\Shop;

use App\Repositories\ShopOrderRepository;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    private $shopOrderRepository;

    /**
     * OrderCotroller conctructor
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->shopOrderRepository = app(ShopOrderRepository::class);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->shopOrderRepository->getAllWithPaginate();

        //$orders = DB::table('orders')->orderBy('id','desc')->paginate(15);

        //dd($orders);

        return view('shop.orders.index', compact('orders'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd(__METHOD__, \request());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd(__METHOD__, \request());
    }

}
