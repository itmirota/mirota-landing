@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4">
    <form
        action="{{ route('products.update', $product) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <input
            type="text"
            name="name"
            value="{{ $product->name }}"
            class="border p-2 w-full"
        >

        <textarea
            name="description"
            class="border p-2 w-full"
        >{{ $product->description }}</textarea>

        <div>
            <label>Gambar Produk</label>

            <input
                type="file"
                name="image"
                class="border p-2 w-full"
            >
        </div>

        <button
            type="submit"
            class="bg-primary text-white px-4 py-2"
        >
            Update
        </button>
    </form>
</div>
@endsection