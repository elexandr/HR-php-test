<h2>Список продуктов в заказе</h2>
<ul>
    @foreach ($products as $product)
        <li> {{ $product->name }} </li>
    @endforeach
</ul>
<h2>На сумму: {{ $sum }} </h2>