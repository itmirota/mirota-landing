@props(['articles'])

@if($articles->isNotEmpty())
<section class="bg-white py-20">
    <div class="container mx-auto max-w-6xl px-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-primary md:text-4xl">{{ __('home.articles_title') }}</h2>
                <div class="mt-3 h-1 w-16 rounded-full bg-accent"></div>
            </div>
            <a href="{{ route('article.index') }}" class="font-semibold text-primary hover:text-accent">
                {{ __('home.articles_all') }} →
            </a>
        </div>

        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($articles as $article)
                <x-article-card :article="$article" />
            @endforeach
        </div>
    </div>
</section>
@endif