@extends('layouts.app')

@section('title', 'Dashboard User')

@section('styles')
<style>
    .dashboard-header {
        margin-bottom: 30px;
    }

    .welcome-card {
        border: none;
        border-radius: 18px;
        overflow: hidden;
    }

    .stat-card {
        border: none;
        border-radius: 16px;
        transition: .2s;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
    }

    .stat-number {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .section-card {
        border: none;
        border-radius: 16px;
    }

    .order-row {
        padding: 16px 0;
        border-bottom: 1px solid #eee;
    }

    .order-row:last-child {
        border-bottom: none;
    }

    .status-badge {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 20px;
    }

    .menu-cta {
        border: none;
        border-radius: 18px;
        padding: 30px;
    }
</style>
@endsection

@section('content')

<div class="container py-5">

    {{-- HEADER --}}
    <div class="dashboard-header">
        <h2 class="fw-bold mb-1">
            Halo, {{ auth()->user()->name }} 👋
        </h2>

        <p class="text-muted mb-0">
            Mau pesan makanan apa hari ini?
        </p>
    </div>


    {{-- STAT CARDS --}}
    <div class="row g-4 mb-4">

        {{-- CART --}}
        <div class="col-md-4">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div
                            class="stat-icon"
                            style="background: #e7f1ff;"
                        >
                            🛒
                        </div>

                        <div>
                            <div class="text-muted small">
                                Keranjang
                            </div>

                            <div class="stat-number">
                                {{ $cartCount }}
                            </div>

                            <div class="text-muted small">
                                item
                            </div>
                        </div>

                    </div>

                    <a
                        href="{{ route('cart.index') }}"
                        class="btn btn-outline-primary w-100 mt-3"
                    >
                        Lihat Keranjang
                    </a>

                </div>
            </div>
        </div>


        {{-- TOTAL ORDERS --}}
        <div class="col-md-4">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div
                            class="stat-icon"
                            style="background: #e8f8ee;"
                        >
                            📦
                        </div>

                        <div>
                            <div class="text-muted small">
                                Total Pesanan
                            </div>

                            <div class="stat-number">
                                {{ $totalOrders }}
                            </div>

                            <div class="text-muted small">
                                pesanan
                            </div>
                        </div>

                    </div>

                    <a
                        href="{{ route('orders.index') }}"
                        class="btn btn-outline-success w-100 mt-3"
                    >
                        Lihat Pesanan
                    </a>

                </div>
            </div>
        </div>


        {{-- ACTIVE ORDERS --}}
        <div class="col-md-4">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div
                            class="stat-icon"
                            style="background: #fff4e5;"
                        >
                            ⏳
                        </div>

                        <div>
                            <div class="text-muted small">
                                Pesanan Aktif
                            </div>

                            <div class="stat-number">
                                {{ $activeOrders }}
                            </div>

                            <div class="text-muted small">
                                sedang diproses
                            </div>
                        </div>

                    </div>

                    <a
                        href="{{ route('orders.index') }}"
                        class="btn btn-outline-warning w-100 mt-3"
                    >
                        Cek Status
                    </a>

                </div>
            </div>
        </div>

    </div>


    {{-- RECENT ORDERS --}}
    <div class="card section-card shadow-sm mb-4">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>
                    <h5 class="fw-bold mb-1">
                        Pesanan Terbaru
                    </h5>

                    <p class="text-muted small mb-0">
                        Riwayat pesanan terakhirmu
                    </p>
                </div>

                <a
                    href="{{ route('orders.index') }}"
                    class="btn btn-sm btn-outline-primary"
                >
                    Lihat Semua
                </a>

            </div>


            @if($recentOrders->count() > 0)

                @foreach($recentOrders as $order)

                    <div class="order-row">

                        <div class="row align-items-center g-3">

                            <div class="col-md-4">

                                <div class="fw-semibold">
                                    {{ $order->order_code }}
                                </div>

                                <div class="text-muted small">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </div>

                            </div>


                            <div class="col-md-3">

                                <div class="text-muted small">
                                    Total
                                </div>

                                <div class="fw-semibold">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </div>

                            </div>


                            <div class="col-md-3">

                                @if($order->status === 'Menunggu')

                                    <span class="badge bg-warning text-dark status-badge">
                                        Menunggu
                                    </span>

                                @elseif($order->status === 'Diproses')

                                    <span class="badge bg-primary status-badge">
                                        Diproses
                                    </span>

                                @elseif($order->status === 'Selesai')

                                    <span class="badge bg-success status-badge">
                                        Selesai
                                    </span>

                                @else

                                    <span class="badge bg-secondary status-badge">
                                        {{ $order->status }}
                                    </span>

                                @endif

                            </div>


                            <div class="col-md-2 text-md-end">

                                <a
                                    href="{{ route('orders.show', $order) }}"
                                    class="btn btn-sm btn-outline-secondary"
                                >
                                    Detail
                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            @else

                <div class="text-center py-4">

                    <div style="font-size: 45px;">
                        📦
                    </div>

                    <h6 class="fw-bold mt-2">
                        Belum ada pesanan
                    </h6>

                    <p class="text-muted small">
                        Pesananmu akan muncul di sini.
                    </p>

                </div>

            @endif

        </div>

    </div>


    {{-- CTA --}}
    <div class="card menu-cta shadow-sm">

        <div class="row align-items-center">

            <div class="col-md-8">

                <h4 class="fw-bold mb-2">
                    🍔 Mau pesan makanan?
                </h4>

                <p class="text-muted mb-md-0">
                    Pilih makanan favoritmu dan lakukan pemesanan dengan mudah.
                </p>

            </div>

            <div class="col-md-4 text-md-end mt-3 mt-md-0">

                <a
                    href="{{ route('menu') }}"
                    class="btn btn-primary px-4 py-2"
                >
                    Lihat Menu →
                </a>

            </div>

        </div>

    </div>

</div>

@endsection