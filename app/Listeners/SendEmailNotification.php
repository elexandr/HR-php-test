<?php

namespace App\Listeners;

use App\Events\onCompletedOrder;
use App\Mail\OrderCompletedMail;
use App\Repositories\ShopOrderRepository;
use Illuminate\Support\Facades\Mail;

class SendEmailNotification
{
    private $shopOrderRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->shopOrderRepository = app(ShopOrderRepository::class);
    }

    /**
     * Handle the event.
     * Управление отправкой нотификаций на email
     *
     * @param  onCompletedOrder  $event
     * @return void
     */
    public function handle(onCompletedOrder $event)
    {
        $id = $event->order->id;
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

}
