@extends('shop.layout')

@section('content')

    <div class="row">
        <div class="col-md-6 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Состав заказа</span>
                <span class="badge badge-secondary badge-pill"></span>
            </h4>
               <table class="table">
                <thead>
                <tr>
                    <th scope="col">Товар</th>
                    <th class="text-center" scope="col">К-во</th>
                    <th class="text-center" scope="col">Цена</th>
                    <th class="text-center" scope="col">Сумма</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->orderproduct as $product)
                    <tr>
                        <th scope="row">{{ $order->product->where('id', $product['product_id'])->first()->name }}</th>
                        <td class="text-center">{{ $product['quantity'] }}</td>
                        <td class="text-center">{{ $product['price'] }}</td>
                        <td class="text-center">{{ $product['sum'] = $product['price'] * $product['quantity'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th scope="col" colspan="3">Итого</th>
                    <th class="text-center" scope="col">{{ $order->orderproduct->sum('sum') }}</th>
                </tr>
                </tbody>
            </table>

        </div>
        <div class="col-md-6 order-md-1">
            <h4 class="mb-3">Информация о заказе № {{ $order->id }}</h4>
            @if($errors->any())
                <div class="border border-danger text-danger mt-2 pt-2">
                    <ul>
                        @foreach($errors->all() as $messages)
                            <li>
                                {{ $messages }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session()->get('successOrderUpdate'))
                <div class="border border-success mt-2 text-center text-success">
                    Заказ успешно обновлен!
                </div>
            @endif




            <form method="POST" action="{{ route('orders.update', $order->id ) }}" class="needs-validation" novalidate="" _lpchecked="1">
                {{method_field('PATCH')}}
                {{ csrf_field() }}
                <div class="mb-3">
                    <label for="name">Партнер <span class="text-muted">(Обязательное поле)</span></label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ Old('name') ?? $order->partner->name }}">
                </div>

                <div class="mb-3">
                    <label for="client_email">Email <span class="text-muted">(Обязательное поле)</span></label>
                    <input type="email" class="form-control" name="client_email" id="client_email" value="{{ Old('client_email') ?? $order->client_email }}">
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="status">Статус заказа</label>
                        <select class="custom-select d-block w-100" name="status" id="status" required="">
                            @foreach($statuses as $key => $status)
                                <option {{ $order->status == $key ? 'selected' : '' }} value="{{ $key }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Обновить</button>
            </form>
        </div>
    </div>
@stop