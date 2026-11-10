@props(['title', 'subtitle' => null, 'label' => null])

<section class="relative overflow-hidden bg-linear-to-br from-primary-dark via-primary to-primary-light pt-36 pb-16 text-white">
    <div class="absolute -right-24 -top-24 h-80 w-80 rounded-full bg-white/10"></div>
    <div class="absolute -bottom-28 left-1/3 h-60 w-60 rounded-full bg-accent/25"></div>

    <div class="relative container mx-auto px-6">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-200">{{ $label ?? __('nav.about') }}</p>
        <h1 class="mt-3 text-4xl font-extrabold md:text-6xl">{{ $title }}</h1>
        @if($subtitle)
            <p class="mt-4 max-w-2xl text-lg text-white/85">{{ $subtitle }}</p>
        @endif
    </div>
</section>