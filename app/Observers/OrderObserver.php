<?php

namespace App\Observers;

use App\Events\onCompletedOrder;
use App\Models\Order;
use Illuminate\Support\Facades\Event;


class OrderObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function Updated(Order $order)
    {
        //  Если завершен (код 20) - вызываем событие отправки нотификаций
        $changes = $order->getDirty();
        if (array_key_exists('status', $changes)) {
            $changes['status'] == 20 ? Event::fire(new onCompletedOrder($order)) : '';
        }
    }

}