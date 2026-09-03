@extends('layouts.app')

@section('title', 'Edit Makanan')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h3 class="mb-4">
                        Edit Makanan
                    </h3>


                    @if($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    <form
                        method="POST"
                        action="{{ route('admin.foods.update', $food) }}"
                        enctype="multipart/form-data"
                    >

                        @csrf
                        @method('PUT')


                        {{-- NAMA --}}

                        <div class="mb-3">

                            <label class="form-label">
                                Nama Makanan
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name', $food->name) }}"
                                required
                            >

                        </div>


                        {{-- KATEGORI --}}

                        <div class="mb-3">

                            <label class="form-label">
                                Kategori
                            </label>

                            <select
                                name="category_id"
                                class="form-select"
                                required
                            >

                                @foreach($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        {{ $food->category_id == $category->id ? 'selected' : '' }}
                                    >
                                        {{ $category->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- DESKRIPSI --}}

                        <div class="mb-3">

                            <label class="form-label">
                                Deskripsi
                            </label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="3"
                            >{{ old('description', $food->description) }}</textarea>

                        </div>


                        {{-- HARGA --}}

                        <div class="mb-3">

                            <label class="form-label">
                                Harga
                            </label>

                            <input
                                type="number"
                                name="price"
                                class="form-control"
                                value="{{ old('price', $food->price) }}"
                                min="0"
                                required
                            >

                        </div>


                        {{-- STOK --}}

                        <div class="mb-3">

                            <label class="form-label">
                                Stok
                            </label>

                            <input
                                type="number"
                                name="stock"
                                class="form-control"
                                value="{{ old('stock', $food->stock) }}"
                                min="0"
                                required
                            >

                        </div>


                        {{-- GAMBAR --}}

                        <div class="mb-3">

                            <label class="form-label">
                                Ganti Gambar
                            </label>

                            <input
                                type="file"
                                name="image"
                                class="form-control"
                                accept="image/*"
                            >

                            @if($food->image)

                                <div class="mt-3">

                                    <p class="text-muted mb-2">
                                        Gambar saat ini:
                                    </p>

                                    <img
                                        src="{{ asset('storage/' . $food->image) }}"
                                        width="150"
                                        height="110"
                                        class="rounded"
                                        style="object-fit: cover;"
                                    >

                                </div>

                            @endif

                        </div>


                        {{-- BUTTON --}}

                        <div class="mt-4">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Update
                            </button>

                            <a
                                href="{{ route('admin.foods.index') }}"
                                class="btn btn-secondary"
                            >
                                Kembali
                            </a>

                        </div>


                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection