<?php

namespace App\Http\Controllers\Shop;

use App\Http\Requests\OrderUpdateRequest;
use App\Partner;
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
        $order = $this->shopOrderRepository->getEdit($id);

        $statuses = $this->orderStatuses();

        return view('shop.orders.edit', compact('order', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Order $order
     * @param OrderUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(Order $order, OrderUpdateRequest $request)
    {
        $data = $request->validated();

        $partner = Partner::find($order->partner_id);

        $partnerUpdateResult = $partner->update($data);
        $orderUpdateResult = $order->update($data);

        ($partnerUpdateResult && $orderUpdateResult) ? session()->flash('successOrderUpdate', true): '';

        return redirect()->route('orders.edit', $order->id);
    }

    /** Возвращаем статусы. Вынес так как метод и сами статусы могут измениться
     * @return array
     */
    public function orderStatuses(){
        $statuses = [
            0 => 'Новый',
            10 => 'Подтвержден',
            20 => 'Завершен',
        ];
        return $statuses;
    }

}
