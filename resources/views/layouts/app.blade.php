<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<meta
    name="csrf-token"
    content="{{ csrf_token() }}"
>

<title>
    @yield('title', 'PreOrder')
</title>

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
>

<style>

    body {
        background: #cecece;
    }

    .navbar {
        box-shadow: 0 2px 12px rgba(0,0,0,.08);
    }

    .navbar-brand {
        letter-spacing: .3px;
    }

    .nav-link {
        transition: .2s;
    }

    .nav-link:hover {
        opacity: .8;
    }

    .cart-badge {
        font-size: 10px;
        position: relative;
        top: -2px;
    }

    .flash-container {
        position: fixed;
        top: 80px;
        right: 20px;
        z-index: 1050;
        width: 320px;
    }

    .flash-message {
        box-shadow: 0 5px 20px rgba(0,0,0,.12);
    }

</style>

@yield('styles')

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

<div class="container">

    {{-- BRAND --}}

    <a
        class="navbar-brand fw-bold"
        href="{{ auth()->user()->role === 'admin'
            ? route('admin.dashboard')
            : route('menu') }}"
    >
        PreOrder Kantin
    </a>


    {{-- MOBILE BUTTON --}}

    <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarMenu"
    >

        <span class="navbar-toggler-icon"></span>

    </button>


    <div
        class="collapse navbar-collapse"
        id="navbarMenu"
    >


        {{-- USER MENU --}}

        @if(auth()->user()->role === 'user')

            <ul class="navbar-nav me-auto">

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="{{ route('menu') }}"
                    >
                        Menu
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="{{ route('cart.index') }}"
                    >
                        🛒 Keranjang

                        @php
                            $cartCount = collect(
                                session('cart', [])
                            )->sum('quantity');
                        @endphp

                        @if($cartCount > 0)

                            <span class="badge bg-danger rounded-pill cart-badge">
                                {{ $cartCount }}
                            </span>

                        @endif

                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="{{ route('orders.index') }}"
                    >
                        Pesanan Saya
                    </a>

                </li>

            </ul>


        {{-- ADMIN MENU --}}

        @else

            <ul class="navbar-nav me-auto">

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="{{ route('admin.dashboard') }}"
                    >
                        Dashboard
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="{{ route('admin.categories.index') }}"
                    >
                        Kategori
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="{{ route('admin.foods.index') }}"
                    >
                        Makanan
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="{{ route('admin.orders.index') }}"
                    >
                        Pesanan
                    </a>

                </li>

            </ul>

        @endif


        {{-- USER --}}

        <div class="d-flex align-items-center gap-3">

            <span class="text-white small">

                {{ auth()->user()->name }}

            </span>


            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    class="btn btn-light btn-sm px-3"
                >
                    Logout
                </button>

            </form>

        </div>


    </div>

</div>

</nav>

{{-- FLASH MESSAGE --}}

<div class="flash-container">

@if(session('success'))

    <div
        class="alert alert-success alert-dismissible fade show flash-message"
        role="alert"
    >

        ✓ {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

    </div>

@endif


@if(session('error'))

    <div
        class="alert alert-danger alert-dismissible fade show flash-message"
        role="alert"
    >

        {{ session('error') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

    </div>

@endif

</div>

<main>

@yield('content')

</main>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

@yield('scripts')

</body>

</html>

