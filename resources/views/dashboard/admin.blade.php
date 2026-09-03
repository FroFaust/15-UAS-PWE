@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('styles')
<style>
    .dashboard-header {
        margin-bottom: 30px;
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

    .action-card {
        border: none;
        border-radius: 16px;
        transition: .2s;
        height: 100%;
    }

    .action-card:hover {
        transform: translateY(-3px);
    }

    .action-icon {
        font-size: 30px;
        margin-bottom: 12px;
    }
</style>
@endsection

@section('content')

<div class="container py-5">

    {{-- HEADER --}}
    <div class="dashboard-header">

        <h2 class="fw-bold mb-1">
            Dashboard Admin
        </h2>

        <p class="text-muted mb-0">
            Selamat datang, {{ auth()->user()->name }} 👋
        </p>

    </div>


    {{-- STAT CARDS --}}
    <div class="row g-4 mb-4">

        {{-- FOODS --}}
        <div class="col-md-6 col-lg-3">

            <div class="card stat-card shadow-sm">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div
                            class="stat-icon"
                            style="background: #e7f1ff;"
                        >
                            🍔
                        </div>

                        <div>

                            <div class="text-muted small">
                                Total Makanan
                            </div>

                            <div class="stat-number">
                                {{ $totalFoods }}
                            </div>

                            <div class="text-muted small">
                                menu tersedia
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- CATEGORIES --}}
        <div class="col-md-6 col-lg-3">

            <div class="card stat-card shadow-sm">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div
                            class="stat-icon"
                            style="background: #f1e8ff;"
                        >
                            🗂️
                        </div>

                        <div>

                            <div class="text-muted small">
                                Kategori
                            </div>

                            <div class="stat-number">
                                {{ $totalCategories }}
                            </div>

                            <div class="text-muted small">
                                kategori
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ORDERS --}}
        <div class="col-md-6 col-lg-3">

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

                </div>

            </div>

        </div>


        {{-- PENDING --}}
        <div class="col-md-6 col-lg-3">

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
                                Menunggu
                            </div>

                            <div class="stat-number">
                                {{ $pendingOrders }}
                            </div>

                            <div class="text-muted small">
                                perlu diproses
                            </div>

                        </div>

                    </div>

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
                        Pesanan terbaru dari pengguna
                    </p>

                </div>

                <a
                    href="{{ route('admin.orders.index') }}"
                    class="btn btn-sm btn-outline-primary"
                >
                    Lihat Semua
                </a>

            </div>


            @if($recentOrders->count() > 0)

                @foreach($recentOrders as $order)

                    <div class="order-row">

                        <div class="row align-items-center g-3">

                            <div class="col-md-3">

                                <div class="fw-semibold">
                                    {{ $order->order_code }}
                                </div>

                                <div class="text-muted small">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </div>

                            </div>


                            <div class="col-md-3">

                                <div class="text-muted small">
                                    Pemesan
                                </div>

                                <div class="fw-semibold">
                                    {{ $order->user->name }}
                                </div>

                            </div>


                            <div class="col-md-2">

                                <div class="text-muted small">
                                    Total
                                </div>

                                <div class="fw-semibold">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </div>

                            </div>


                            <div class="col-md-2">

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
                                    href="{{ route('admin.orders.show', $order) }}"
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
                        Pesanan pengguna akan muncul di sini.
                    </p>

                </div>

            @endif

        </div>

    </div>


    {{-- QUICK ACTIONS --}}
    <div class="mb-3">

        <h5 class="fw-bold">
            Aksi Cepat
        </h5>

    </div>


    <div class="row g-4">

        {{-- FOODS --}}
        <div class="col-md-4">

            <div class="card action-card shadow-sm">

                <div class="card-body p-4 text-center">

                    <div class="action-icon">
                        🍔
                    </div>

                    <h5 class="fw-bold">
                        Kelola Makanan
                    </h5>

                    <p class="text-muted small">
                        Tambah, edit, atau hapus makanan.
                    </p>

                    <a
                        href="{{ route('admin.foods.index') }}"
                        class="btn btn-primary"
                    >
                        Kelola Makanan
                    </a>

                </div>

            </div>

        </div>


        {{-- CATEGORIES --}}
        <div class="col-md-4">

            <div class="card action-card shadow-sm">

                <div class="card-body p-4 text-center">

                    <div class="action-icon">
                        🗂️
                    </div>

                    <h5 class="fw-bold">
                        Kelola Kategori
                    </h5>

                    <p class="text-muted small">
                        Atur kategori makanan yang tersedia.
                    </p>

                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="btn btn-outline-primary"
                    >
                        Kelola Kategori
                    </a>

                </div>

            </div>

        </div>


        {{-- ORDERS --}}
        <div class="col-md-4">

            <div class="card action-card shadow-sm">

                <div class="card-body p-4 text-center">

                    <div class="action-icon">
                        📦
                    </div>

                    <h5 class="fw-bold">
                        Kelola Pesanan
                    </h5>

                    <p class="text-muted small">
                        Lihat dan proses pesanan pengguna.
                    </p>

                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="btn btn-outline-success"
                    >
                        Lihat Pesanan
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection