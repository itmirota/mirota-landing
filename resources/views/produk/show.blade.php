@extends('layouts.app')
@section('title', $product->localized('name').' | PT Mirota KSM')
@section('og_image', $product->image ? asset('storage/'.$product->image) : '')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((string) ($product->localized('short_description') ?: $product->localized('description'))), 160))

@section('content')
<x-page-header :title="$product->localized('name')" :label="__('nav.products')" />

<section class="bg-linear-to-b from-sky/70 to-white py-16">
    <div class="container mx-auto max-w-6xl px-6">

        <a href="{{ route('produk.index') }}" class="text-sm font-semibold text-primary hover:text-accent">← {{ __('product.back') }}</a>

        <div class="mt-6 grid gap-10 lg:grid-cols-2">

            {{-- Foto --}}
            <div class="relative flex aspect-square items-center justify-center overflow-hidden rounded-3xl bg-white p-8 shadow-lg">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->localized('name') }}"
                         class="h-full w-full object-contain">
                @else
                    <span class="text-8xl">🥛</span>
                @endif

                @if($product->is_featured)
                    <span class="absolute left-5 top-5 rounded-full bg-accent px-4 py-1.5 text-xs font-bold text-white shadow">
                        ★ {{ __('product.featured') }}
                    </span>
                @endif
            </div>

            {{-- Informasi --}}
            <div>
                <h2 class="text-3xl font-extrabold text-primary-dark md:text-4xl">{{ $product->localized('name') }}</h2>

                @if($product->localized('short_description'))
                    <p class="mt-3 text-lg text-slate-600">{{ $product->localized('short_description') }}</p>
                @endif

                @if($product->localized('description'))
                    <h3 class="mt-8 text-lg font-bold text-primary">{{ __('product.description') }}</h3>
                    <div class="mt-2 leading-relaxed text-slate-700">
                        {!! nl2br(e($product->localized('description'))) !!}
                    </div>
                @endif

                <div class="mt-8">
                    <x-nutrition-table :nutrition="$product->nutrition" />
                </div>

                <div class="mt-8 flex flex-wrap gap-4">
                    @if(filled(config('company.shopee_url')))
                        <a href="{{ config('company.shopee_url') }}" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 rounded-lg bg-[#EE4D2D] px-6 py-3 font-semibold text-white transition hover:brightness-95">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/>
                            </svg>
                            {{ __('product.buy_now') }}
                        </a>
                    @endif

                    <a href="{{ route('contact', ['type' => 'customer_care']) }}"
                    class="rounded-lg border-2 border-primary px-6 py-3 font-semibold text-primary transition hover:bg-primary hover:text-white">
                        {{ __('product.ask') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@if($related->isNotEmpty())
<section class="bg-white py-16">
    <div class="container mx-auto max-w-6xl px-6">
        <h2 class="text-2xl font-extrabold text-primary md:text-3xl">{{ __('product.related') }}</h2>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($related as $item)
                <x-product-card :product="$item" />
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection