@props(['article'])

<a href="{{ route('article.show', $article->slug) }}"
   class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-md transition hover:-translate-y-1 hover:shadow-xl">

    <div class="aspect-[16/10] overflow-hidden bg-linear-to-br from-primary to-primary-light">
        @if($article->coverUrl())
            <img src="{{ $article->coverUrl() }}" alt="{{ $article->localized('title') }}"
                 class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
        @else
            <div class="flex h-full items-center justify-center text-5xl">📰</div>
        @endif
    </div>

    <div class="flex flex-1 flex-col p-5">
        <div class="flex items-center gap-3 text-xs">
            <span class="rounded-full bg-accent/10 px-3 py-1 font-bold text-accent">
                {{ __('article.categories.'.$article->category) }}
            </span>
            <span class="text-slate-500">{{ $article->published_at?->translatedFormat('d F Y') }}</span>
        </div>

        <h3 class="mt-3 text-lg font-bold leading-snug text-primary-dark group-hover:text-primary">
            {{ $article->localized('title') }}
        </h3>
        <p class="mt-2 line-clamp-3 text-sm text-slate-600">{{ $article->localized('excerpt') }}</p>

        <span class="mt-4 text-sm font-semibold text-primary">{{ __('article.read_more') }} →</span>
    </div>
</a>