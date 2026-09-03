@extends('layouts.app')

@section('title', 'Struk Pesanan - ' . $order->order_code)

@section('content')

<style>

    @media print {

        .no-print {
            display: none !important;
        }

        .navbar {
            display: none !important;
        }

        body {
            background: white !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
        }

    }

</style>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow-sm">

                <div class="card-body p-4">


                    {{-- HEADER --}}

                    <div class="text-center mb-4">

                        <h2>
                            PreOrder
                        </h2>

                        <p class="text-muted mb-0">
                            Bukti Pemesanan
                        </p>

                    </div>


                    {{-- INFORMASI PESANAN --}}

                    <div class="row mb-4">

                        <div class="col-6">

                            <small class="text-muted">
                                Kode Pesanan
                            </small>

                            <div>

                                <strong>
                                    {{ $order->order_code }}
                                </strong>

                            </div>

                        </div>


                        <div class="col-6 text-end">

                            <small class="text-muted">
                                Status
                            </small>

                            <div>

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

                            </div>

                        </div>

                    </div>


                    {{-- PEMESAN --}}

                    <div class="mb-4">

                        <small class="text-muted">
                            Pemesan
                        </small>

                        <div>

                            <strong>
                                {{ $order->user->name }}
                            </strong>

                        </div>

                        <div class="text-muted">
                            {{ $order->user->email }}
                        </div>

                    </div>


                    {{-- DETAIL PESANAN --}}

                    <table class="table">

                        <thead>

                            <tr>

                                <th>Makanan</th>

                                <th class="text-center">
                                    Qty
                                </th>

                                <th class="text-end">
                                    Subtotal
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($order->orderDetails as $detail)

                                <tr>

                                    <td>

                                        {{ $detail->food->name }}

                                        <div class="small text-muted">

                                            Rp
                                            {{ number_format($detail->price, 0, ',', '.') }}

                                        </div>

                                    </td>


                                    <td class="text-center">
                                        {{ $detail->quantity }}
                                    </td>


                                    <td class="text-end">

                                        Rp
                                        {{ number_format($detail->subtotal, 0, ',', '.') }}

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>


                        <tfoot>

                            <tr>

                                <th colspan="2">
                                    Total
                                </th>

                                <th class="text-end">

                                    Rp
                                    {{ number_format($order->total, 0, ',', '.') }}

                                </th>

                            </tr>

                        </tfoot>

                    </table>


                    {{-- FOOTER --}}

                    <div class="text-center text-muted mt-4">

                        <small>
                            Terima kasih telah melakukan pemesanan.
                        </small>

                    </div>


                    {{-- BUTTON --}}

                    <div class="d-flex gap-2 justify-content-center mt-4 no-print">

                        <button
                            onclick="window.print()"
                            class="btn btn-primary"
                        >
                            🖨️ Print Struk
                        </button>

                        <a
                            href="{{ route('orders.index') }}"
                            class="btn btn-secondary"
                        >
                            Riwayat Pesanan
                        </a>

                    </div>


                </div>

            </div>

        </div>

    </div>

</div>

@endsection