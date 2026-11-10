@props(['products'])

@if($products->isNotEmpty())
<section class="bg-white py-20">
    <div class="container mx-auto max-w-6xl px-6">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-primary md:text-4xl">{{ __('home.products_title') }}</h2>
            <div class="mx-auto mt-3 h-1 w-16 rounded-full bg-accent"></div>
            <p class="mx-auto mt-4 max-w-2xl text-slate-600">{{ __('home.products_text') }}</p>
        </div>

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('produk.index') }}"
               class="inline-block rounded-lg border-2 border-primary px-8 py-3 font-semibold text-primary transition hover:bg-primary hover:text-white">
                {{ __('home.products_all') }}
            </a>
        </div>
    </div>
</section>
@endif