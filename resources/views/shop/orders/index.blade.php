@extends('shop.layout')

@section('content')

    <h1>Список заказов</h1>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>ID</th>
                <th>Партнер</th>
                <th class="text-center">Стоимость</th>
                <th>Состав</th>
                <th>Статус</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td> <a target="_blank" href="{{ route("orders.edit", ['order' => $order->id]) }}">{{ $order->id }}</a></td>
                    <td>{{ $order->partner->name }}</td>
                    <td class="text-center">{{ $order->order_sum }}</td>
                    <td>{{ $order->products }}</td>
                    <td>{{ $order->text_status }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

        @if($orders->total() > $orders->count())
            <br>
            <div class="row justify-content-center">
                {{ $orders->links("pagination::bootstrap-4") }}
            </div>
        @endif

    @stop