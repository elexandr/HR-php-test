@extends('shop.layout')

@section('content')
    @if( $temp )
        <h1>Текущая температура в Брянске {{ $temp }} С&deg; </h1>
    @else
        <h4>Для отображения текущей температы в Брянске, добавьте в параметр API_WEATHER_KEY .env файла, API Key Яндекса</h4>
    @endif
@stop