@extends('layouts.app')

@section('title', 'Kategori Makanan')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Kategori Makanan</h2>
            <p class="text-muted mb-0">
                Kelola kategori makanan.
            </p>
        </div>

        <a
            href="{{ route('admin.categories.create') }}"
            class="btn btn-primary"
        >
            + Tambah Kategori
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

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>
                            <th>#</th>
                            <th>Nama Kategori</th>
                            <th width="200">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($categories as $category)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $category->name }}
                                    </strong>
                                </td>

                                <td>

                                    <a
                                        href="{{ route('admin.categories.edit', $category) }}"
                                        class="btn btn-warning btn-sm"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route('admin.categories.destroy', $category) }}"
                                        method="POST"
                                        class="d-inline"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus kategori ini?')"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="3"
                                    class="text-center text-muted py-4"
                                >
                                    Belum ada kategori.
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