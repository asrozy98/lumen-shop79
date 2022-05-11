<header class="d-print-none">
    <div class="px-3 py-2 navbar-dark bg-primary">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="{{ url('/') }}"
                    class="d-block my-2 my-lg-0 me-lg-auto text-decoration-none @if (request()->segment(1) == null) text-white @else text-white-50 @endif">
                    <i class="bi bi-house-fill d-block text-center" style="font-size: 1rem;"></i>
                    Lumen Shoping Card 79
                </a>
            </div>
        </div>
    </div>
    <div class="navbar-dark bg-primary col-auto">
        <div class="container">
            <a href="{{ url('shop') }}"
                class="text-decoration-none @if (request()->segment(1) == 'shop') text-white @else text-white-50 @endif">
                Shop
            </a>
            <a href="{{ url('cart') }}"
                class="text-decoration-none @if (request()->segment(1) == 'cart') text-white @else text-white-50 @endif">
                Cart
            </a>
        </div>
    </div>
</header>
