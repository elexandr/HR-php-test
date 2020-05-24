<?php

namespace App\Http\Controllers\Shop;

use App\Http\Requests\OrderUpdateRequest;
use App\Mail\OrderCompletedMail;
use App\Models\Partner;
use App\Repositories\ShopOrderRepository;
use App\Models\Order;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class OrderController extends BaseController
{

    // Локигу получения информации выносим в Репозиторий
    private $shopOrderRepository;

    /**
     * OrderController constructor     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->shopOrderRepository = app(ShopOrderRepository::class);
    }


    /**
     *  Оборажаем список заказов согласно обязательной части ТЗ с пагинацией
     *
     * @return Response
     */
    public function index()
    {
        $orders = $this->shopOrderRepository->getAllWithPaginate(25);

        return view('shop.orders.index', compact('orders'));
    }


    /**
     *  Получаем данные и отображаем форму редактирования
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $order = $this->shopOrderRepository->getOne($id);

        $statuses = $this->shopOrderRepository->getOrderStatuses();

        return view('shop.orders.edit', compact('order', 'statuses'));
    }

    /**
     *  Обновляем информацию по заказу и в случае завершения инциируем отправку email
     *
     * @param Order $order
     * @param OrderUpdateRequest $request
     * @return Response
     */
    public function update(Order $order, OrderUpdateRequest $request)
    {
        $data = $request->validated();

        if(empty($data)){
            abort(404);
        }

        $partner = Partner::find($order->partner_id);

        // Обновляем данные
        $partnerUpdateResult = $partner->update($data);
        $orderUpdateResult = $order->update($data);

        // ПРоверяем, что изменился статус и если он 20 - инициируем отправку уведомлений
        $changes = $order->getChanges();
        if (array_key_exists('status', $changes)) {
            $changes['status'] == 20 ? $this->orderCompletedNotification($order->id) : '';
        }

        // Передем в вид информацию, что все успешно
        ($partnerUpdateResult && $orderUpdateResult) ? session()->flash('successOrderUpdate', true) : '';

        return redirect()->route('orders.edit', $order->id);
    }

    /** Управление отправкой нотификаций на email
     *
     * @param $id
     */
    public function orderCompletedNotification($id)
    {
        // Получаем данные для письма
        //Все emails
        $emails = $this->shopOrderRepository->getOrderEmails($id);
        // Список продуктов
        $products = $this->shopOrderRepository->getOrderProducts($id);
        // Сумму заказа
        $sum = $this->shopOrderRepository->getOrderSUm($id);
        // Формируем тему
        $subject = "Заказ №'$id' выполнен.";

        // Отсылаем письма каждому получателю через очередь и подготовленный шаблон
        foreach ($emails as $email) {
            Mail::to($email->client_email)->queue(new OrderCompletedMail($products, $sum, $subject));
        }
    }


    /** Показываем заказы по вкладкам срочности
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showUrgentsTabs()
    {
        // Получаем все заказы
        $orders = $this->shopOrderRepository->getAll();

        // Фильтруем по параметрам из ТЗ Просроченные
        $overdueOrders = $orders->filter(function ($item) {
            return $item->delivery_dt < now() && $item->status == 10;
        })->sortByDesc('delivery_dt')->slice(0, 50);

        // Фильтруем по параметрам из ТЗ Текущие
        $currentOrders = $orders->filter(function ($item) {
            return $item->delivery_dt > now()
                && $item->delivery_dt < now()->addHours(24)
                && $item->status == 10;
        })->sortBy('delivery_dt');

        // Фильтруем по параметрам из ТЗ Новые
        $newOrders = $orders->filter(function ($item) {
            return $item->delivery_dt > now() && $item->status == 0;
        })->sortBy('delivery_dt')->slice(0, 50);

        // Фильтруем по параметрам из ТЗ Выполненные
        $completedOrders = $orders->filter(function ($item) {
            return date("Y-m-d", strtotime($item->delivery_dt)) == date("Y-m-d")
                && $item->status == 20;
        })->sortByDesc('delivery_dt')->slice(0, 50);

        return view('shop.orders.show_urgents_tabs', compact('overdueOrders', 'currentOrders', 'newOrders', 'completedOrders'));
    }

}
