@extends('shop.layout')

@section('content')

    <h1>Список заказов</h1>

    <div class="table-responsive">

        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>ID</th>
                <th>Партнер</th>
                <th>Стоимость</th>
                <th>Состав</th>
                <th>Статус</th>
            </tr>
            </thead>
            <tbody>

            @foreach($orders as $order)
                {{--{{ dd($order['orderproduct']) }}--}}
{{--                @foreach($order->orderproduct as $item)
                {{ dd($item) }}
                @endforeach--}}
                <tr>
                    <td {{--href="{{ route("shop.orders.edit", ['order' => $order->id]) }}--}}>{{ $order->id }}</td>
                    <td>{{ $order->partner->name }}</td>
                    <td>{{ $order->order_sum }}</td>
                    <td>{{ $order->products }}</td>
                    <td>{{ $order->status }}</td>
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