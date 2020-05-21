<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('homepage') ? 'active' : ''  }}"
                   href="{{ asset('/') }}">
                    <span data-feather="home"></span>
                    Погода в Брянске <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('orders.index') ? 'active' : ''  }}"
                   href="{{ asset('/shop/orders') }}">
                    <span data-feather="file"></span>
                    Все заказы
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('show-urgents-tabs') ? 'active' : ''  }}"
                   href="{{ asset('/shop/show-urgents-tabs') }}">
                    <span data-feather="file"></span>
                    Заказы по вкладкам
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('products') ? 'active' : ''  }}"
                   href="{{ asset('/shop/products ') }}">
                    <span data-feather="shopping-cart"></span>
                    Список продуктов
                </a>
            </li>
        </ul>
    </div>
</nav>