@extends('layouts.app')

@section('title', 'Tambah Makanan')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h3 class="mb-4">
                        Tambah Makanan
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
                        action="{{ route('admin.foods.store') }}"
                        enctype="multipart/form-data"
                    >

                        @csrf


                        {{-- NAMA --}}

                        <div class="mb-3">

                            <label class="form-label">
                                Nama Makanan
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name') }}"
                                required
                            >

                            @error('name')

                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

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

                                <option value="">
                                    -- Pilih Kategori --
                                </option>

                                @foreach($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}
                                    >
                                        {{ $category->name }}
                                    </option>

                                @endforeach

                            </select>

                            @error('category_id')

                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

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
                            >{{ old('description') }}</textarea>

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
                                value="{{ old('price') }}"
                                min="0"
                                required
                            >

                            @error('price')

                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

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
                                value="{{ old('stock', 0) }}"
                                min="0"
                                required
                            >

                            @error('stock')

                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- GAMBAR --}}

                        <div class="mb-3">

                            <label class="form-label">
                                Gambar
                            </label>

                            <input
                                type="file"
                                name="image"
                                class="form-control"
                                accept="image/*"
                            >

                            @error('image')

                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- BUTTON --}}

                        <div class="mt-4">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Simpan
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