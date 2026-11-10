@extends('layouts.app')
@section('title', __('product.title').' | PT Mirota KSM')

@section('content')
<x-page-header :title="__('product.title')" :subtitle="__('product.subtitle')" :label="__('nav.products')" />

<section class="bg-linear-to-b from-sky/70 to-white py-16">
    <div class="container mx-auto max-w-6xl px-6" x-data="{ q: '' }">

        @if($products->isEmpty())
            <p class="py-16 text-center text-slate-500">{{ __('product.empty') }}</p>
        @else
            {{-- Pencarian --}}
            <div class="mx-auto max-w-xl">
                <div class="relative">
                    <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                    <input type="search" x-model.debounce.150ms="q" placeholder="{{ __('product.search') }}"
                           class="w-full rounded-full border border-slate-200 bg-white py-3 pl-12 pr-5 text-sm shadow-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                </div>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($products as $product)
                    <div x-show="!q || @js(mb_strtolower($product->name.' '.$product->name_en)).includes(q.toLowerCase())"
                         x-transition.opacity>
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>

            <p x-cloak x-show="q && $el.parentElement.querySelectorAll('.grid > div:not([style*=\'display: none\'])').length === 0"
               class="py-12 text-center text-slate-500">{{ __('product.no_results') }}</p>
        @endif
    </div>
</section>
@endsection