@extends('layouts.app')

@section('title', 'Menu Makanan')

@section('styles')

<style>

    .menu-header {
        background: linear-gradient(
            135deg,
            #0d6efd,
            #0a58ca
        );

        color: white;
        border-radius: 20px;
        padding: 35px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(13,110,253,.2);
    }


    .menu-header h1 {
        font-weight: 700;
    }


    .food-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        transition: .25s ease;
    }


    .food-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,.12) !important;
    }


    .food-image {
        height: 210px;
        object-fit: cover;
    }


    .food-placeholder {
        height: 210px;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }


    .food-price {
        font-size: 18px;
        font-weight: 700;
        color: #0d6efd;
    }


    .quantity-control {
        transition: .2s;
    }


    .quantity-control .btn {
        width: 45px;
        font-size: 20px;
        font-weight: bold;
    }


    .quantity-input {
        font-weight: 600;
        background: white !important;
    }


    .add-to-cart {
        transition: .2s;
    }


    .loading {
        opacity: .6;
        pointer-events: none;
    }


    .category-title {
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }


    .category-title::before {
        content: '';
        width: 5px;
        height: 25px;
        background: #0d6efd;
        border-radius: 5px;
    }

</style>

@endsection

@section('content')

<div class="container py-5">

{{-- HEADER --}}

<div class="menu-header">

    <div class="row align-items-center">

        <div class="col-md-8">

            <h1 class="mb-2">
                Mau makan apa hari ini? 🍽️
            </h1>

            <p class="mb-0 opacity-75">
                Pilih makanan favoritmu dan tentukan jumlah pesanannya.
            </p>

        </div>


        <div class="col-md-4 text-md-end mt-3 mt-md-0">

            <a
                href="{{ route('cart.index') }}"
                class="btn btn-light px-4"
            >
                🛒 Lihat Keranjang
            </a>

        </div>

    </div>

</div>


{{-- MENU --}}

@foreach($categories as $category)

    @if($category->foods->count() > 0)

        <h4 class="category-title mt-5">
            {{ $category->name }}
        </h4>


        <div class="row">

            @foreach($category->foods as $food)

                @php

                    $cartQuantity =
                        isset($cart[$food->id])
                            ? $cart[$food->id]['quantity']
                            : 0;

                @endphp


                <div class="col-lg-4 col-md-6 mb-4">

                    <div class="card food-card h-100 shadow-sm">


                        {{-- IMAGE --}}

                        @if($food->image)

                            <img
                                src="{{ asset('storage/' . $food->image) }}"
                                class="food-image"
                                alt="{{ $food->name }}"
                            >

                        @else

                            <div class="food-placeholder">
                                Tidak ada gambar
                            </div>

                        @endif


                        <div class="card-body d-flex flex-column p-4">


                            <h5 class="fw-bold">
                                {{ $food->name }}
                            </h5>


                            <p class="text-muted small flex-grow-1">

                                {{ $food->description ?: 'Tidak ada deskripsi.' }}

                            </p>


                            <div class="food-price mb-1">

                                Rp {{ number_format($food->price, 0, ',', '.') }}

                            </div>


                            <small class="text-muted mb-3">

                                Stok tersedia:
                                <strong>{{ $food->stock }}</strong>

                            </small>


                            {{-- ORDER BUTTON --}}

                            <div
                                class="order-area"
                                data-food-id="{{ $food->id }}"
                                data-stock="{{ $food->stock }}"
                                data-quantity="{{ $cartQuantity }}"
                            >

                                @if($cartQuantity > 0)

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
                                                class="form-control text-center quantity-input"
                                                value="{{ $cartQuantity }}"
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

                                @else

                                    <button
                                        type="button"
                                        class="btn btn-primary w-100 add-to-cart"
                                    >
                                        🛒 Pesan
                                    </button>

                                @endif

                            </div>


                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

@endforeach

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
    | Request ke Cart
    |--------------------------------------------------------------------------
    */

    async function updateCart(foodId, quantity) {

        const method =
            quantity === 1 && !document
                .querySelector(
                    `.order-area[data-food-id="${foodId}"] .quantity-control`
                )
                ? 'POST'
                : 'PUT';


        const response = await fetch(
            `/cart/${foodId}`,
            {
                method: method,

                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },

                body: JSON.stringify({
                    quantity: quantity
                })
            }
        );


        const data = await response.json();


        if (!response.ok || !data.success) {
            throw new Error(
                data.message || 'Terjadi kesalahan.'
            );
        }


        return data;

    }


    /*
    |--------------------------------------------------------------------------
    | Render Counter
    |--------------------------------------------------------------------------
    */

    function renderCounter(area, quantity) {

        area.dataset.quantity = quantity;


        area.innerHTML = `

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
                        class="form-control text-center quantity-input"
                        value="${quantity}"
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

        `;

    }


    /*
    |--------------------------------------------------------------------------
    | Render Tombol Pesan
    |--------------------------------------------------------------------------
    */

    function renderButton(area) {

        area.dataset.quantity = 0;


        area.innerHTML = `

            <button
                type="button"
                class="btn btn-primary w-100 add-to-cart"
            >
                🛒 Pesan
            </button>

        `;

    }


    /*
    |--------------------------------------------------------------------------
    | Tombol Pesan
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        async function (event) {

            const button =
                event.target.closest('.add-to-cart');


            if (!button) {
                return;
            }


            const area =
                button.closest('.order-area');


            const foodId =
                area.dataset.foodId;


            button.disabled = true;

            button.innerHTML =
                '<span class="spinner-border spinner-border-sm me-1"></span> Menambahkan';


            try {

                const data =
                    await updateCart(
                        foodId,
                        1
                    );


                renderCounter(
                    area,
                    data.quantity
                );


            } catch (error) {

                alert(error.message);

                button.disabled = false;

                button.innerHTML =
                    '🛒 Pesan';

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Tombol + dan -
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        async function (event) {

            const plus =
                event.target.closest('.quantity-plus');

            const minus =
                event.target.closest('.quantity-minus');


            if (!plus && !minus) {
                return;
            }


            const button =
                plus || minus;


            const area =
                button.closest('.order-area');


            const input =
                area.querySelector('.quantity-input');


            const current =
                parseInt(input.value);


            const stock =
                parseInt(area.dataset.stock);


            let newQuantity;


            if (plus) {

                if (current >= stock) {
                    return;
                }

                newQuantity =
                    current + 1;

            } else {

                newQuantity =
                    current - 1;

            }


            area.classList.add('loading');


            try {

                const data =
                    await updateCart(
                        area.dataset.foodId,
                        newQuantity
                    );


                if (data.quantity <= 0) {

                    renderButton(area);

                } else {

                    input.value =
                        data.quantity;

                    area.dataset.quantity =
                        data.quantity;

                }


            } catch (error) {

                alert(error.message);

            } finally {

                area.classList.remove('loading');

            }

        }
    );

});

</script>

@endsection


