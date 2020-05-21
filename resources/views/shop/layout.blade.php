<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>
        @yield('title', 'Александр Сыроваткин - Тестовое задание')
    </title>

    @yield('csrf')

    <!-- Bootstrap styles for this template -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body>
@include('shop.includes.topnavbar')

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            @include('shop.includes.sidebar')
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

            @section('content')

                    <h1 class="h2">Добро пожаловать"</h1>

            @show

        </main>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>

</body>
</html>
