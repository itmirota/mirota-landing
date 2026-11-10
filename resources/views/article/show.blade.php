@extends('layouts.app')
@section('title', $article->localized('title').' | PT Mirota KSM')
@section('og_image', $article->coverUrl())
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((string) $article->localized('excerpt')), 160))

@section('content')
<section class="relative overflow-hidden bg-linear-to-br from-primary-dark via-primary to-primary-light pt-36 pb-14 text-white">
    <div class="absolute -right-24 -top-24 h-80 w-80 rounded-full bg-white/10"></div>
    <div class="relative container mx-auto max-w-3xl px-6">
        <a href="{{ route('article.index') }}" class="text-sm font-semibold text-sky-200 hover:text-white">← {{ __('article.back') }}</a>

        <div class="mt-5 flex flex-wrap items-center gap-3 text-sm">
            <span class="rounded-full bg-accent px-3 py-1 text-xs font-bold">{{ __('article.categories.'.$article->category) }}</span>
            <span class="text-white/80">{{ $article->published_at?->translatedFormat('d F Y') }}</span>
            <span class="text-white/80">· {{ $article->readingMinutes() }} {{ __('article.min_read') }}</span>
        </div>

        <h1 class="mt-4 text-3xl font-extrabold leading-tight md:text-5xl">{{ $article->localized('title') }}</h1>
    </div>
</section>

<article class="bg-white pb-16">
    <div class="container mx-auto max-w-3xl px-6">

        @if($article->coverUrl())
            <img src="{{ $article->coverUrl() }}" alt="{{ $article->localized('title') }}"
                 class="relative -mt-8 aspect-[16/9] w-full rounded-3xl border-4 border-white object-cover shadow-xl">
        @endif

        <div class="prose prose-lg prose-slate mt-10 max-w-none prose-headings:text-primary-dark prose-a:text-primary prose-img:rounded-2xl">
            {!! $article->html() !!}
        </div>

        {{-- Bagikan --}}
        @php $shareText = urlencode($article->localized('title').' - '.url()->current()); @endphp
        <div class="mt-10 flex flex-wrap items-center gap-3 border-t pt-6">
            <span class="text-sm font-semibold text-slate-600">{{ __('article.share') }}:</span>
            <a href="https://wa.me/?text={{ $shareText }}" target="_blank" rel="noopener"
               class="rounded-lg bg-accent px-4 py-2 text-sm font-semibold text-white hover:brightness-110">WhatsApp</a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener"
               class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-primary-dark">Facebook</a>
        </div>
    </div>
</article>

@if($related->isNotEmpty())
<section class="bg-sky/50 py-16">
    <div class="container mx-auto max-w-6xl px-6">
        <h2 class="text-2xl font-extrabold text-primary md:text-3xl">{{ __('article.related') }}</h2>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($related as $item)
                <x-article-card :article="$item" />
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection