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

@section('custom_js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function price_update(el) {
            var myEl = $(el);
            var edit_id = myEl.attr('id')
            var price = myEl.val()

            if (edit_id != '' && price != '') {
                $.ajax({
                    url: 'products/updateprice',
                    type: 'post',
                    data: {id: edit_id, price: price},
                    success: function (response) {
                        if (response.result) {
                            myEl.removeClass(['border-danger', 'text-danger']);
                            myEl.addClass('border-success')
                            setTimeout(function () {
                                myEl.removeClass('border-success');
                            }, 2000);
                        }
                    },
                    error: function error(allresonse) {// Обрабатываем ошибки валидации с сервера
                        // Извлекаем ошибки
                        let responseText = JSON.parse(allresonse.responseText);
                        let err = responseText.errors;
                        // Формируем текст с ошибками и задаем стили для полей
                        var errortext;
                        for (let key in err) {
                            // текст ошибок
                            errortext = err[key] + '\n';
                        }
                        // бордер
                        myEl.addClass(['border-danger', 'text-danger']);
                        alert(errortext)
                    }
                });
            } else {
                alert('Не оставляйте поле цены пустым');
                myEl.addClass(['border-danger']);
            }
        }
    </script>


@stop
