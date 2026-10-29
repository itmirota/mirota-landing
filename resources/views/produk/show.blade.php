@extends('layouts.app')

@section('content')

<section class="py-20">

    <div class="container mx-auto px-4">

        <div class="grid md:grid-cols-2 gap-10">

            <div>
                <img
                    src="{{ $product->image
                        ? asset('storage/' . $product->image)
                        : asset('images/no-image.png') }}"
                    alt="{{ $product->name }}"
                    class="w-full h-48 object-cover rounded-lg"
                >
            </div>

            <div>

                <h1 class="text-4xl font-bold mb-4">
                    {{ $product->name }}
                </h1>

                <p class="text-gray-700 leading-relaxed">
                    {{ $product->description }}
                </p>

            </div>

            <a
                href="{{ route('products.edit', $product) }}"
                class="text-blue-600"
            >
                Edit
            </a>

        </div>

    </div>

</section>

@endsection