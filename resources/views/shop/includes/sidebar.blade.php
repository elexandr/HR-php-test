<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ asset('/') }}">
                    <span data-feather="home"></span>
                    Погода в Брянске <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ asset('/shop/orders') }}">
                    <span data-feather="file"></span>
                    Заказы
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ asset('/shop/products ') }}">
                    <span data-feather="shopping-cart"></span>
                    ПРодукты
                </a>
            </li>
        </ul>
    </div>
</nav>