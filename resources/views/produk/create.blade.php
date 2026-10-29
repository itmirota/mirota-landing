@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <h1 class="text-4xl font-bold mb-4">
        Tambah data produk
    </h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="gap-4">
            <label>Nama Produk</label>
            <input
                type="text"
                name="name"
                placeholder="Nama Produk"
                class="border p-2 w-full rounded-xl mt-2"
            >
        </div>

        <div class="py-2">
            <label>Deskripsi</label>
            <textarea
                name="description"
                class="border p-2 w-full"
            ></textarea>
        </div>

        <div>
            <label class="block">Gambar Produk</label>

            <input
                type="file"
                name="image"
                class="block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-md file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-50 file:text-blue-700
                hover:file:bg-blue-100"
            />
        </div>

        <button
            type="submit"
            class="bg-primary text-white px-4 py-2"
        >
            Simpan
        </button>
    </form>
</div>
@endsection