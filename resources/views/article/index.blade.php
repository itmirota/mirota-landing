@extends('layouts.app')
@section('title', __('article.title').' | PT Mirota KSM')

@section('content')
<x-page-header :title="__('article.title')" :subtitle="__('article.subtitle')" :label="__('nav.articles')" />

@php
    $featured = ($articles->currentPage() === 1 && ! $category) ? $articles->first() : null;
    $list     = $featured ? $articles->getCollection()->slice(1) : $articles->getCollection();
@endphp

<section class="bg-linear-to-b from-sky/70 to-white py-16">
    <div class="container mx-auto max-w-6xl px-6">

        <x-draft-note />

        {{-- Filter kategori --}}
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('article.index') }}"
               class="rounded-full px-5 py-2 text-sm font-semibold transition
                      {{ ! $category ? 'bg-primary text-white shadow' : 'bg-white text-primary shadow-sm hover:bg-primary/10' }}">
                {{ __('article.all') }}
            </a>
            @foreach(trans('article.categories') as $key => $label)
                <a href="{{ route('article.index', ['kategori' => $key]) }}"
                   class="rounded-full px-5 py-2 text-sm font-semibold transition
                          {{ $category === $key ? 'bg-primary text-white shadow' : 'bg-white text-primary shadow-sm hover:bg-primary/10' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if($articles->isEmpty())
            <p class="mt-16 text-center text-slate-500">{{ __('article.empty') }}</p>
        @else
            {{-- Artikel unggulan --}}
            @if($featured)
                <a href="{{ route('article.show', $featured->slug) }}"
                   class="group mt-10 grid overflow-hidden rounded-3xl bg-white shadow-lg transition hover:shadow-2xl lg:grid-cols-2">
                    <div class="min-h-64 overflow-hidden bg-linear-to-br from-primary to-primary-light">
                        @if($featured->coverUrl())
                            <img src="{{ $featured->coverUrl() }}" alt="{{ $featured->localized('title') }}"
                                 class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="flex h-full min-h-64 items-center justify-center text-7xl">📰</div>
                        @endif
                    </div>
                    <div class="flex flex-col justify-center p-8 lg:p-12">
                        <div class="flex items-center gap-3 text-xs">
                            <span class="rounded-full bg-accent px-3 py-1 font-bold text-white">{{ __('article.featured') }}</span>
                            <span class="text-slate-500">{{ $featured->published_at?->translatedFormat('d F Y') }}</span>
                        </div>
                        <h2 class="mt-4 text-2xl font-extrabold leading-tight text-primary-dark md:text-3xl">
                            {{ $featured->localized('title') }}
                        </h2>
                        <p class="mt-3 text-slate-600">{{ $featured->localized('excerpt') }}</p>
                        <span class="mt-5 font-semibold text-primary">{{ __('article.read_more') }} →</span>
                    </div>
                </a>
            @endif

            {{-- Grid --}}
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($list as $article)
                    <x-article-card :article="$article" />
                @endforeach
            </div>

            <div class="mt-12">{{ $articles->links() }}</div>
        @endif
    </div>
</section>
@endsection