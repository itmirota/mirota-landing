@props(['product'])

<a href="{{ route('produk.show', $product->slug) }}"
   class="group flex flex-col overflow-hidden rounded-3xl bg-white shadow-md transition hover:-translate-y-1 hover:shadow-xl">

    <div class="relative aspect-square overflow-hidden bg-linear-to-br from-sky to-white">
        @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->localized('name') }}" loading="lazy"
                 class="h-full w-full object-contain p-6 transition duration-500 group-hover:scale-110">
        @else
            <div class="flex h-full items-center justify-center text-6xl">🥛</div>
        @endif

        @if($product->is_featured)
            <span class="absolute left-4 top-4 rounded-full bg-accent px-3 py-1 text-xs font-bold text-white shadow">
                ★ {{ __('product.featured') }}
            </span>
        @endif
    </div>

    <div class="flex flex-1 flex-col p-5">
        <h3 class="text-lg font-bold leading-snug text-primary-dark group-hover:text-primary">
            {{ $product->localized('name') }}
        </h3>
        <p class="mt-2 line-clamp-2 text-sm text-slate-600">
            {{ $product->localized('short_description') ?: \Illuminate\Support\Str::limit(strip_tags((string) $product->localized('description')), 90) }}
        </p>
        <span class="mt-4 text-sm font-semibold text-primary">{{ __('product.detail') }} →</span>
    </div>
</a>