@extends('layouts.app')

@section('title', 'Pesanan ' . $order->order_code)

@section('content')

<style>

    @media print {

        .no-print {
            display: none !important;
        }

        body {
            background: white !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
        }

        .navbar {
            display: none !important;
        }

    }

</style>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow-sm">

                <div class="card-body p-4">


                    {{-- HEADER STRUK --}}

                    <div class="text-center mb-4">

                        <h2>
                            PreOrder
                        </h2>

                        <p class="text-muted">
                            Order Ticket
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

                                <strong>
                                    {{ $order->status }}
                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- PEMESAN --}}

                    <div class="mb-4">

                        <small class="text-muted">
                            Pemesan
                        </small>

                        <div>
                            {{ $order->user->name }}
                        </div>

                        <div class="text-muted">
                            {{ $order->user->email }}
                        </div>

                    </div>


                    {{-- DETAIL MAKANAN --}}

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


                    {{-- UPDATE STATUS --}}

                    <div class="mt-4 no-print">

                        <h5>
                            Update Status
                        </h5>


                        <form
                            method="POST"
                            action="{{ route('admin.orders.updateStatus', $order) }}"
                        >

                            @csrf
                            @method('PUT')


                            <div class="input-group">

                                <select
                                    name="status"
                                    class="form-select"
                                >

                                    <option
                                        value="Menunggu"
                                        {{ $order->status === 'Menunggu' ? 'selected' : '' }}
                                    >
                                        Menunggu
                                    </option>

                                    <option
                                        value="Diproses"
                                        {{ $order->status === 'Diproses' ? 'selected' : '' }}
                                    >
                                        Diproses
                                    </option>

                                    <option
                                        value="Siap Diambil"
                                        {{ $order->status === 'Siap Diambil' ? 'selected' : '' }}
                                    >
                                        Siap Diambil
                                    </option>

                                    <option
                                        value="Selesai"
                                        {{ $order->status === 'Selesai' ? 'selected' : '' }}
                                    >
                                        Selesai
                                    </option>

                                    <option
                                        value="Dibatalkan"
                                        {{ $order->status === 'Dibatalkan' ? 'selected' : '' }}
                                    >
                                        Dibatalkan
                                    </option>

                                </select>


                                <button class="btn btn-primary">
                                    Update
                                </button>

                            </div>

                        </form>

                    </div>


                    {{-- BUTTONS --}}

                    <div class="d-flex gap-2 justify-content-center mt-4 no-print">

                        <button
                            onclick="window.print()"
                            class="btn btn-success"
                        >
                            🖨️ Cetak Struk
                        </button>


                        <a
                            href="{{ route('admin.orders.index') }}"
                            class="btn btn-secondary"
                        >
                            Kembali
                        </a>

                    </div>


                </div>

            </div>

        </div>

    </div>

</div>

@endsection