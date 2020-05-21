@extends('shop.layout')

@section('csrf')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
@stop

@section('content')
    <h1>Список продуктов</h1>

    <div class="table-responsive">

        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>ID</th>
                <th>Наименование</th>
                <th>Поставщик</th>
                <th class="text-center">Цена</th>
            </tr>
            </thead>
            <tbody>

            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->vendor->name }}</td>
                    <td class="text-center"><input onchange="price_update(this)" class="text-right" id="{{ $product->id }}" type="text"
                               value="{{ $product->price }}"></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if($products->total() > $products->count())
        <br>
        <div class="row justify-content-center">
            {{ $products->links("pagination::bootstrap-4") }}
        </div>

    @endif

@stop


