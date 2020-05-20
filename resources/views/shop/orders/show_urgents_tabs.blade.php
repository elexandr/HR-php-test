@extends('shop.layout')

@section('content')

    <h1>Список заказов по срочности</h1>
    {{--$overdueOrdes $currentOrdes $newOrdes $completedOrdes--}}
    {{-- overdue-orders', 'current-orders', 'new-orders', 'completed-orders--}}

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#overdue-orders" role="tab" aria-controls="nav-home" aria-selected="true">Просроченные</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#current-orders" role="tab" aria-controls="nav-profile" aria-selected="false">Текущие</a>
            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#new-orders" role="tab" aria-controls="nav-contact" aria-selected="false">Новые</a>
            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#completed-orders" role="tab" aria-controls="nav-contact" aria-selected="false">Завершенные</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="overdue-orders" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr class="no-border-top">
                            <th>ID</th>
                            <th>Партнер</th>
                            <th>Стоимость</th>
                            <th>Состав</th>
                            <th>Доставка</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach($overdueOrders as $overdueOrder)
                        <tr>
                            <td> <a target="_blank" href="{{ route("orders.edit", ['order' => $overdueOrder->id]) }}">{{ $overdueOrder->id }}</a></td>
                            <td>{{ $overdueOrder->partner->name }}</td>
                            <td>{{ $overdueOrder->order_sum }}</td>
                            <td>{{ $overdueOrder->products }}</td>
                            <td>{{ $overdueOrder->delivery_dt }}</td>
                            <td>{{ $overdueOrder->status }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="current-orders" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr class="no-border-top">
                            <th>ID</th>
                            <th>Партнер</th>
                            <th>Стоимость</th>
                            <th>Состав</th>
                            <th>Доставка</th>
                            <th>Статус</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($currentOrders as $currentOrder)
                            <tr>
                                <td> <a target="_blank" href="{{ route("orders.edit", ['order' => $currentOrder->id]) }}">{{ $currentOrder->id }}</a></td>
                                <td>{{ $currentOrder->partner->name }}</td>
                                <td>{{ $currentOrder->order_sum }}</td>
                                <td>{{ $currentOrder->products }}</td>
                                <td>{{ $currentOrder->delivery_dt }}</td>
                                <td>{{ $currentOrder->status }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
        </div>

        <div class="tab-pane fade" id="new-orders" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr class="no-border-top">
                            <th>ID</th>
                            <th>Партнер</th>
                            <th>Стоимость</th>
                            <th>Состав</th>
                            <th>Доставка</th>
                            <th>Статус</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($newOrders as $newOrder)
                            <tr>
                                <td> <a target="_blank" href="{{ route("orders.edit", ['order' => $newOrder->id]) }}">{{ $newOrder->id }}</a></td>
                                <td>{{ $newOrder->partner->name }}</td>
                                <td>{{ $newOrder->order_sum }}</td>
                                <td>{{ $newOrder->products }}</td>
                                <td>{{ $newOrder->delivery_dt }}</td>
                                <td>{{ $newOrder->status }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
        </div>

        <div class="tab-pane fade" id="completed-orders" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr class="no-border-top">
                            <th>ID</th>
                            <th>Партнер</th>
                            <th>Стоимость</th>
                            <th>Состав</th>
                            <th>Доставка</th>
                            <th>Статус</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($completedOrders as $completedOrder)
                            <tr>
                                <td> <a target="_blank" href="{{ route("orders.edit", ['order' => $completedOrder->id]) }}">{{ $completedOrder->id }}</a></td>
                                <td>{{ $completedOrder->partner->name }}</td>
                                <td>{{ $completedOrder->order_sum }}</td>
                                <td>{{ $completedOrder->products }}</td>
                                <td>{{ $completedOrder->delivery_dt }}</td>
                                <td>{{ $completedOrder->status }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>





@stop