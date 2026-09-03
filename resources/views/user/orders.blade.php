@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>
                Riwayat Pesanan
            </h2>

            <p class="text-muted mb-0">
                Lihat pesanan yang pernah kamu buat.
            </p>

        </div>

    </div>


    @if($orders->count() === 0)

        <div class="alert alert-info">
            Belum ada pesanan.
        </div>

    @else

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>

                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($orders as $order)

                                <tr>

                                    <td>
                                        <strong>
                                            {{ $order->order_code }}
                                        </strong>
                                    </td>


                                    <td>
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>


                                    <td>
                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                    </td>


                                    <td>

                                        @if($order->status === 'Menunggu')

                                            <span class="badge bg-warning text-dark">
                                                Menunggu
                                            </span>

                                        @elseif($order->status === 'Diproses')

                                            <span class="badge bg-primary">
                                                Diproses
                                            </span>

                                        @elseif($order->status === 'Siap Diambil')

                                            <span class="badge bg-info text-dark">
                                                Siap Diambil
                                            </span>

                                        @elseif($order->status === 'Selesai')

                                            <span class="badge bg-success">
                                                Selesai
                                            </span>

                                        @else

                                            <span class="badge bg-danger">
                                                Dibatalkan
                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        <a
                                            href="{{ route('orders.show', $order) }}"
                                            class="btn btn-primary btn-sm"
                                        >
                                            Lihat Struk
                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @endif


    <a
        href="{{ route('menu') }}"
        class="btn btn-secondary mt-3"
    >
        ← Kembali ke Menu
    </a>

</div>

@endsection