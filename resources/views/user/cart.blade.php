@extends('layouts.app')
@section('title', 'Keranjang')
@section('styles')

<style>

    .cart-header {
        margin-bottom: 30px;
    }

    .cart-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }

    .cart-item {
        padding: 20px 0;
        border-bottom: 1px solid #eee;
        transition: .2s;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .food-image {
        width: 85px;
        height: 85px;
        min-width: 85px;
        min-height: 85px;
        max-width: 85px;
        max-height: 85px;
        object-fit: cover;
        object-position: center;
        border-radius: 12px;
        display: block;
        flex-shrink: 0;
        image-rendering: auto;
    }

    .food-placeholder {
        width: 85px;
        height: 85px;
        border-radius: 12px;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 12px;
        text-align: center;
    }

    .food-name {
        font-weight: 600;
        margin-bottom: 4px;
    }

    .food-price {
        color: #6c757d;
        font-size: 14px;
    }

    .quantity-control {
        width: 130px;
    }

    .quantity-control .btn {
        width: 38px;
        font-weight: bold;
        font-size: 18px;
    }

    .quantity-input {
        text-align: center;
        font-weight: 600;
        background: white !important;
    }

    .remove-btn {
        border: none;
        background: transparent;
        color: #dc3545;
        font-size: 22px;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        transition: .2s;
    }

    .remove-btn:hover {
        background: #ffe5e8;
        color: #bb2d3b;
    }

    .summary-card {
        border: none;
        border-radius: 16px;
        position: sticky;
        top: 90px;
    }

    .summary-total {
        font-size: 24px;
        font-weight: 700;
        color: #0d6efd;
    }

    .empty-cart {
        border: none;
        border-radius: 18px;
        padding: 60px 20px;
        text-align: center;
    }

    .empty-icon {
        font-size: 55px;
        margin-bottom: 15px;
    }

    .cart-loading {
        pointer-events: none;
    }

    .cart-loading .food-image {
    opacity: 1;
    }
    
    @media (max-width: 767px) {
        .cart-item {
            padding: 20px 0;
        }
        .quantity-control {
            width: 120px;
        }
        .item-subtotal {
            margin-top: 10px;
        }
    }

</style>

@endsection

@section('content')

<div class="container py-5">

{{-- HEADER --}}

<div class="cart-header">

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h2 class="fw-bold mb-1">
                Keranjang 🛒
            </h2>

            <p class="text-muted mb-0">
                Periksa pesananmu sebelum checkout.
            </p>

        </div>

        <a
            href="{{ route('menu') }}"
            class="btn btn-outline-primary"
        >
            ← Kembali ke Menu
        </a>

    </div>

</div>

{{-- EMPTY CART --}}

@if(count($cart) === 0)

    <div class="card shadow-sm empty-cart">

        <div class="empty-icon">
            🛒
        </div>

        <h4 class="fw-bold">
            Keranjang masih kosong
        </h4>

        <p class="text-muted">
            Yuk pilih makanan yang ingin kamu pesan.
        </p>

        <div>

            <a
                href="{{ route('menu') }}"
                class="btn btn-primary px-4"
            >
                Lihat Menu
            </a>

        </div>

    </div>

@else

    @php

        $total = 0;
        $itemCount = 0;

        foreach ($cart as $item) {

            $total +=
                $item['price'] *
                $item['quantity'];

            $itemCount +=
                $item['quantity'];

        }

    @endphp

    <div class="row g-4">

        {{-- ITEMS --}}

        <div class="col-lg-8">

            <div class="card cart-card shadow-sm">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between mb-2">

                        <h5 class="fw-bold mb-0">
                            Pesanan Kamu
                        </h5>

                        <span class="text-muted small">
                            {{ $itemCount }} item
                        </span>

                    </div>

                    <div id="cart-items">

                        @foreach($cart as $item)

                            @php

                                $subtotal =
                                    $item['price'] *
                                    $item['quantity'];

                            @endphp

                            <div
                                class="cart-item"
                                data-food-id="{{ $item['id'] }}"
                                data-price="{{ $item['price'] }}"
                            >

                                <div class="row align-items-center g-3">

                                    {{-- FOOD --}}

                                    <div class="col-md-5">

                                        <div class="d-flex align-items-center gap-3">

                                            @if(!empty($item['image']))

                                                <img
                                                    src="{{ asset('storage/' . $item['image']) }}"
                                                    class="food-image"
                                                    alt="{{ $item['name'] }}"
                                                >

                                            @else

                                                <div class="food-placeholder">
                                                    Tidak ada gambar
                                                </div>

                                            @endif

                                            <div>

                                                <div class="food-name">
                                                    {{ $item['name'] }}
                                                </div>

                                                <div class="food-price">

                                                    Rp
                                                    {{ number_format($item['price'], 0, ',', '.') }}

                                                </div>

                                            </div>


                                        </div>

                                    </div>

                                    {{-- QUANTITY --}}

                                    <div class="col-md-3">

                                        <div class="quantity-control">

                                            <div class="input-group">

                                                <button
                                                    type="button"
                                                    class="btn btn-outline-primary quantity-minus"
                                                >
                                                    −
                                                </button>

                                                <input
                                                    type="text"
                                                    class="form-control quantity-input"
                                                    value="{{ $item['quantity'] }}"
                                                    readonly
                                                >

                                                <button
                                                    type="button"
                                                    class="btn btn-outline-primary quantity-plus"
                                                >
                                                    +
                                                </button>

                                            </div>

                                        </div>

                                    </div>

                                    {{-- SUBTOTAL --}}

                                    <div class="col-md-3">

                                        <div class="item-subtotal fw-bold">

                                            Rp
                                            <span class="subtotal-value">
                                                {{ number_format($subtotal, 0, ',', '.') }}
                                            </span>

                                        </div>

                                    </div>

                                    {{-- REMOVE --}}

                                    <div class="col-md-1 text-end">

                                        <button
                                            type="button"
                                            class="remove-btn"
                                            title="Hapus"
                                        >
                                            ×
                                        </button>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

        {{-- SUMMARY --}}

        <div class="col-lg-4">

            <div class="card summary-card shadow-sm">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        Ringkasan Pesanan
                    </h5>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Jumlah item
                        </span>

                        <span
                            id="summary-item-count"
                            class="fw-semibold"
                        >
                            {{ $itemCount }}
                        </span>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">

                        <span class="fw-semibold">
                            Total
                        </span>

                        <span
                            id="summary-total"
                            class="summary-total"
                        >
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>

                    </div>

                    <a
                        href="{{ route('checkout.index') }}"
                        class="btn btn-success w-100 mt-4 py-2"
                    >
                        Lanjut ke Checkout →
                    </a>

                    <a
                        href="{{ route('menu') }}"
                        class="btn btn-outline-secondary w-100 mt-2"
                    >
                        Tambah Makanan
                    </a>

                </div>

            </div>

        </div>

    </div>

@endif

</div>

@endsection

@section('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {


    const csrfToken =
        document.querySelector(
            'meta[name="csrf-token"]'
        ).getAttribute('content');
    /*
    |--------------------------------------------------------------------------
    | Format Rupiah
    |--------------------------------------------------------------------------
    */
    function formatRupiah(number) {

        return new Intl.NumberFormat(
            'id-ID'
        ).format(number);

    }
    /*
    |--------------------------------------------------------------------------
    | Update cart
    |--------------------------------------------------------------------------
    */
    async function updateCart(
        foodId,
        quantity
    ) {

        const response =
            await fetch(
                `/cart/${foodId}`,
                {

                    method: 'PUT',

                    headers: {

                        'Content-Type':
                            'application/json',

                        'X-CSRF-TOKEN':
                            csrfToken,

                        'Accept':
                            'application/json'

                    },

                    body: JSON.stringify({
                        quantity: quantity
                    })

                }
            );

        const data =
            await response.json();


        if (!response.ok || !data.success) {

            throw new Error(
                data.message ||
                'Gagal memperbarui keranjang.'
            );

        }

        return data;

    }
    /*
    |--------------------------------------------------------------------------
    | Recalculate total
    |--------------------------------------------------------------------------
    */
    function recalculateTotal() {

        let total = 0;

        let itemCount = 0;

        document
            .querySelectorAll('.cart-item')
            .forEach(function (item) {

                const price =
                    parseFloat(
                        item.dataset.price
                    );

                const quantity =
                    parseInt(
                        item.querySelector(
                            '.quantity-input'
                        ).value
                    );

                total +=
                    price * quantity;

                itemCount += quantity;

            });

        const totalElement =
            document.getElementById(
                'summary-total'
            );

        const countElement =
            document.getElementById(
                'summary-item-count'
            );

        if (totalElement) {

            totalElement.textContent =
                'Rp ' +
                formatRupiah(total);

        }

        if (countElement) {

            countElement.textContent =
                itemCount;

        }
        /*
        |--------------------------------------------------------------------------
        | Navbar cart badge
        |--------------------------------------------------------------------------
        */
        const navbarCart =
            document.querySelector(
                'a[href*="/cart"]'
            );

        if (!navbarCart) {
            return;
        }

        let badge =
            navbarCart.querySelector(
                '.cart-badge'
            );

        if (itemCount <= 0) {

            if (badge) {
                badge.remove();
            }

        } else {

            if (!badge) {

                badge =
                    document.createElement(
                        'span'
                    );

                badge.className =
                    'badge bg-danger rounded-pill cart-badge';

                navbarCart.appendChild(
                    badge
                );

            }

            badge.textContent =
                itemCount;

        }

    }
    /*
    |--------------------------------------------------------------------------
    | Quantity
    |--------------------------------------------------------------------------
    */
    document.addEventListener(
        'click',
        async function (event) {

            const plus =
                event.target.closest(
                    '.quantity-plus'
                );

            const minus =
                event.target.closest(
                    '.quantity-minus'
                );

            if (!plus && !minus) {
                return;
            }

            const item =
                event.target.closest(
                    '.cart-item'
                );

            const input =
                item.querySelector(
                    '.quantity-input'
                );

            const foodId =
                item.dataset.foodId;

            const current =
                parseInt(input.value);

            let newQuantity;

            if (plus) {

                newQuantity =
                    current + 1;

            } else {

                newQuantity =
                    current - 1;

            }
            /*
            |--------------------------------------------------------------------------
            | Minimal quantity
            |--------------------------------------------------------------------------
            */
            if (newQuantity < 1) {
                return;
            }

            item.classList.add(
                'cart-loading'
            );

            try {

                const data =
                    await updateCart(
                        foodId,
                        newQuantity
                    );

                input.value =
                    data.quantity;

                const price =
                    parseFloat(
                        item.dataset.price
                    );

                const subtotal =
                    price *
                    data.quantity;

                item.querySelector(
                    '.subtotal-value'
                ).textContent =
                    formatRupiah(
                        subtotal
                    );

                recalculateTotal();

            } catch (error) {

                alert(
                    error.message
                );

            } finally {

                item.classList.remove(
                    'cart-loading'
                );

            }

        }
    );
    /*
    |--------------------------------------------------------------------------
    | Remove item
    |--------------------------------------------------------------------------
    */
    document.addEventListener(
        'click',
        async function (event) {

            const button =
                event.target.closest(
                    '.remove-btn'
                );


            if (!button) {
                return;
            }

            const item =
                button.closest(
                    '.cart-item'
                );

            const foodId =
                item.dataset.foodId;

            if (
                !confirm(
                    'Hapus makanan ini dari keranjang?'
                )
            ) {
                return;
            }

            item.classList.add(
                'cart-loading'
            );

            try {

                const response =
                    await fetch(
                        `/cart/${foodId}`,
                        {

                            method: 'DELETE',

                            headers: {

                                'X-CSRF-TOKEN':
                                    csrfToken,

                                'Accept':
                                    'application/json'

                            }

                        }
                    );

                const data =
                    await response.json();

                if (
                    !response.ok ||
                    !data.success
                ) {

                    throw new Error(
                        data.message ||
                        'Gagal menghapus makanan.'
                    );

                }
                /*
                |--------------------------------------------------------------------------
                | Remove visually
                |--------------------------------------------------------------------------
                */
                item.remove();

                recalculateTotal();
                /*
                |--------------------------------------------------------------------------
                | Kalau sudah kosong
                |--------------------------------------------------------------------------
                */
                const remaining =
                    document.querySelectorAll(
                        '.cart-item'
                    );

                if (remaining.length === 0) {

                    window.location.reload();

                }

            } catch (error) {

                alert(
                    error.message
                );

                item.classList.remove(
                    'cart-loading'
                );

            }

        }
    );


});

</script>

@endsection
