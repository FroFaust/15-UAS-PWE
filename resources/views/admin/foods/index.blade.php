@extends('layouts.app')

@section('title', 'Makanan - Admin')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h2>Daftar Makanan</h2>
            <p class="text-muted mb-0">
                Kelola menu makanan dan stok.
            </p>
        </div>

        <a
            href="{{ route('admin.foods.create') }}"
            class="btn btn-primary"
        >
            + Tambah Makanan
        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover table-bordered align-middle">

                    <thead>

                        <tr>

                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($foods as $food)

                            <tr>

                                <td>

                                    @if($food->image)

                                        <img
                                            src="{{ asset('storage/' . $food->image) }}"
                                            width="80"
                                            height="60"
                                            style="object-fit: cover;"
                                            class="rounded"
                                        >

                                    @else

                                        <span class="text-muted">
                                            Tidak ada
                                        </span>

                                    @endif

                                </td>


                                <td>
                                    <strong>
                                        {{ $food->name }}
                                    </strong>
                                </td>


                                <td>
                                    {{ $food->category->name }}
                                </td>


                                <td>
                                    Rp {{ number_format($food->price, 0, ',', '.') }}
                                </td>


                                <td>

                                    @if($food->stock > 0)

                                        <span class="badge bg-success">
                                            {{ $food->stock }}
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Habis
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <a
                                        href="{{ route('admin.foods.edit', $food) }}"
                                        class="btn btn-warning btn-sm"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route('admin.foods.destroy', $food) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus makanan ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="btn btn-danger btn-sm"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center text-muted py-4"
                                >
                                    Belum ada makanan.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection