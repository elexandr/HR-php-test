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

    private $shopOrderRepository;

    /**
     * OrderCotroller conctructor     *
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
        $orders = $this->shopOrderRepository->getAllWithPaginate(25);

        return view('shop.orders.index', compact('orders'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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

        ($partnerUpdateResult && $orderUpdateResult) ? session()->flash('successOrderUpdate', true) : '';

        return redirect()->route('orders.edit', $order->id);
    }

    /** Возвращаем статусы. Вынес так как метод и сами статусы могут измениться
     * @return array
     */
    public function orderStatuses()
    {
        $statuses = [
            0 => 'Новый',
            10 => 'Подтвержден',
            20 => 'Завершен',
        ];
        return $statuses;
    }

    public function showUrgentsTabs()
    {
        $orders = $this->shopOrderRepository->getAll();

        date_default_timezone_set('Europe/Moscow'); //TODO перенести в настройки

        // Просроченные
        $overdueOrders = $orders->filter(function ($item) {
            return $item->delivery_dt < now() && $item->status == 10;
        })->sortByDesc('delivery_dt')->slice(0, 50);

        // Текущие
        $currentOrders = $orders->filter(function ($item) {
            return $item->delivery_dt > now()
                && $item->delivery_dt < now()->addHours(24)
                && $item->status == 10;
        })->sortBy('delivery_dt');

        // Новые
        $newOrders = $orders->filter(function ($item) {
            return $item->delivery_dt > now() && $item->status == 0;
        })->sortBy('delivery_dt')->slice(0, 50);

        // Выполненные
        $completedOrders = $orders->filter(function ($item) {
            return date( "Y-m-d", strtotime( $item->delivery_dt)) == date("Y-m-d")
                && $item->status == 20;
        })->sortByDesc('delivery_dt')->slice(0, 50);

        return view('shop.orders.show_urgents_tabs', compact('overdueOrders', 'currentOrders', 'newOrders', 'completedOrders'));
    }


}
