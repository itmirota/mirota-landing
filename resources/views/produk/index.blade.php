@extends('layouts.app')

@section('content')

<section class="py-20">
    <div class="container mx-auto px-4">

        <h1 class="text-4xl font-bold mb-3">
            Produk Kami
        </h1>

        <a
            href="{{ route('products.create') }}"
            class="bg-primary text-black px-4 py-2 rounded"
        >
            Tambah Produk
        </a>

        <div class="grid md:grid-cols-3 gap-6 mt-4">

            @foreach($products as $product)

            <a href="{{ route('produk.show', $product->slug) }}"
               class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                <img
                    src="{{ $product->image
                        ? asset('storage/' . $product->image)
                        : asset('images/no-image.png') }}"
                    alt="{{ $product->name }}"
                    class="w-full h-48 object-cover rounded-lg"
                >

                <div class="p-4">

                    <h3 class="font-bold text-lg">
                        {{ $product->name }}
                    </h3>

                    <p class="text-gray-600 mt-2">
                        {{ Str::limit($product->description, 80) }}
                    </p>

                </div>

            </a>

            @endforeach

        </div>

    </div>
</section>

@endsection 