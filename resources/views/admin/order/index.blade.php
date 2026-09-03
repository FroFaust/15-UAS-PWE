@extends('layouts.app')

@section('title', 'Pesanan - Admin')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Pesanan Masuk</h2>
            <p class="text-muted mb-0">
                Kelola pesanan pelanggan.
            </p>
        </div>

    </div>


    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if($orders->count() === 0)

        <div class="alert alert-info">
            Belum ada pesanan masuk.
        </div>

    @else

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th>Kode</th>
                                <th>Pemesan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
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

                                        {{ $order->user->name }}

                                        <div class="small text-muted">
                                            {{ $order->user->email }}
                                        </div>

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
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>


                                    <td>

                                        <a
                                            href="{{ route('admin.orders.show', $order) }}"
                                            class="btn btn-primary btn-sm"
                                        >
                                            Lihat
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

</div>

@endsection