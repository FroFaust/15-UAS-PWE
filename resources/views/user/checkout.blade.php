@extends('layouts.app')

@section('title', 'Checkout')

@section('styles')

<style>
    .checkout-header {
        margin-bottom: 30px;
    }

    .checkout-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }

    .section-title {
        font-weight: 700;
        margin-bottom: 20px;
    }

    .customer-info {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 18px;
    }

    .customer-label {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 3px;
    }

    .customer-value {
        font-weight: 600;
    }

    .order-item {
        padding: 16px 0;
        border-bottom: 1px solid #eee;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .food-image {
        width: 70px;
        height: 70px;
        min-width: 70px;
        object-fit: cover;
        object-position: center;
        border-radius: 12px;
        display: block;
    }

    .food-placeholder {
        width: 70px;
        height: 70px;
        min-width: 70px;
        border-radius: 12px;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 11px;
        text-align: center;
    }

    .food-name {
        font-weight: 600;
        margin-bottom: 4px;
    }

    .food-detail {
        color: #6c757d;
        font-size: 14px;
    }

    .order-subtotal {
        font-weight: 600;
        white-space: nowrap;
    }

    .total-box {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
    }

    .total-label {
        color: #6c757d;
    }

    .total-price {
        font-size: 25px;
        font-weight: 700;
        color: #0d6efd;
    }

    .confirm-btn {
        font-weight: 600;
        padding: 12px;
    }

    .back-btn {
        padding: 11px;
    }

    @media (max-width: 767px) {
        .order-subtotal {
            margin-top: 8px;
        }
    }
</style>

@endsection

@section('content')

<div class="container py-5">

```
{{-- HEADER --}}

<div class="checkout-header">

    <a
        href="{{ route('cart.index') }}"
        class="btn btn-outline-secondary btn-sm mb-3"
    >
        ← Kembali ke Keranjang
    </a>

    <h2 class="fw-bold mb-1">
        Checkout
    </h2>

    <p class="text-muted mb-0">
        Periksa kembali pesananmu sebelum dikonfirmasi.
    </p>

</div>


<div class="row g-4">

    {{-- LEFT SIDE --}}

    <div class="col-lg-8">

        {{-- CUSTOMER --}}

        <div class="card checkout-card shadow-sm mb-4">

            <div class="card-body p-4">

                <h5 class="section-title">
                    Informasi Pemesan
                </h5>

                <div class="customer-info">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <div class="customer-label">
                                Nama
                            </div>

                            <div class="customer-value">
                                {{ auth()->user()->name }}
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="customer-label">
                                Email
                            </div>

                            <div class="customer-value">
                                {{ auth()->user()->email }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ORDER ITEMS --}}

        <div class="card checkout-card shadow-sm">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-2">

                    <h5 class="section-title mb-0">
                        Pesanan Kamu
                    </h5>

                    <span class="text-muted small">
                        {{ count($cart) }} jenis makanan
                    </span>

                </div>


                @foreach($cart as $item)

                    @php
                        $subtotal =
                            $item['price'] *
                            $item['quantity'];
                    @endphp


                    <div class="order-item">

                        <div class="d-flex align-items-center gap-3">

                            {{-- IMAGE --}}

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


                            {{-- INFO --}}

                            <div class="flex-grow-1">

                                <div class="food-name">
                                    {{ $item['name'] }}
                                </div>

                                <div class="food-detail">

                                    {{ $item['quantity'] }} ×
                                    Rp {{ number_format($item['price'], 0, ',', '.') }}

                                </div>

                            </div>


                            {{-- SUBTOTAL --}}

                            <div class="order-subtotal">

                                Rp {{ number_format($subtotal, 0, ',', '.') }}

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>


    {{-- RIGHT SIDE --}}

    <div class="col-lg-4">

        <div class="card checkout-card shadow-sm">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-4">
                    Ringkasan Pesanan
                </h5>


                <div class="d-flex justify-content-between mb-3">

                    <span class="text-muted">
                        Jumlah jenis makanan
                    </span>

                    <span class="fw-semibold">
                        {{ count($cart) }}
                    </span>

                </div>


                <hr>


                <div class="total-box">

                    <div class="d-flex justify-content-between align-items-center">

                        <span class="total-label">
                            Total Pembayaran
                        </span>

                    </div>

                    <div class="total-price mt-1">

                        Rp {{ number_format($total, 0, ',', '.') }}

                    </div>

                </div>


                {{-- CONFIRM FORM --}}

                <form
                    method="POST"
                    action="{{ route('checkout.store') }}"
                    class="mt-4"
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-success w-100 confirm-btn"
                    >
                        ✓ Konfirmasi Pesanan
                    </button>

                </form>


                <a
                    href="{{ route('cart.index') }}"
                    class="btn btn-outline-secondary w-100 back-btn mt-2"
                >
                    Kembali ke Keranjang
                </a>

            </div>

        </div>

    </div>

</div>
```

</div>

@endsection
