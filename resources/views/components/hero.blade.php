@props(['banners' => collect()])

@php
    $slides = collect($banners)->map(fn ($b) => [
        'desktop' => asset('storage/'.$b->image),
        'mobile'  => $b->image_mobile ? asset('storage/'.$b->image_mobile) : null,
        'alt'     => $b->alt ?: 'PT Mirota KSM',
        'link'    => $b->link,
    ])->values();

    // Belum ada banner di panel: pakai foto bawaan yang dipakai hero sebelumnya.
    if ($slides->isEmpty()) {
        $slides = collect([[
            'desktop' => asset('images/building.jpg'),
            'mobile'  => null,
            'alt'     => 'PT Mirota KSM',
            'link'    => null,
        ]]);
    }

    $count     = $slides->count();
    $hasMobile = $slides->contains(fn ($s) => $s['mobile']);
@endphp

<section x-data="heroBanner({{ $count }})"
         @mouseenter="stop()" @mouseleave="play()"
         @touchstart.passive="tx = $event.touches[0].clientX; stop()"
         @touchend="swipe($event); play()"
         class="relative max-h-screen w-full overflow-hidden bg-slate-200 {{ $hasMobile ? 'aspect-[4/5]' : 'aspect-[4/3]' }} sm:aspect-[16/9] xl:aspect-[2/1]"
         aria-roledescription="carousel">

    {{-- Judul untuk mesin pencari dan pembaca layar (tidak terlihat) --}}
    <h1 class="sr-only">{{ __('home.hero_title') }}</h1>

    @foreach($slides as $k => $slide)
        <div class="absolute inset-0 transition-opacity duration-700"
             :class="i === {{ $k }} ? 'z-10 opacity-100' : 'pointer-events-none z-0 opacity-0'"
             @if($k > 0) aria-hidden="true" :aria-hidden="i !== {{ $k }}" @endif>

            @if($slide['link'])
                <a href="{{ $slide['link'] }}" class="block h-full w-full">
            @endif

            <picture>
                @if($slide['mobile'])
                    <source media="(max-width: 639px)" srcset="{{ $slide['mobile'] }}">
                @endif
                <img src="{{ $slide['desktop'] }}" alt="{{ $slide['alt'] }}" draggable="false"
                     class="h-full w-full object-cover object-center"
                     @if($k === 0) fetchpriority="high" @else loading="lazy" @endif>
            </picture>

            @if($slide['link'])
                </a>
            @endif
        </div>
    @endforeach

    @if($count > 1)
        {{-- Panah (desktop) --}}
        <button type="button" @click="prev(); play()" aria-label="Previous"
                class="absolute left-4 top-1/2 z-20 hidden h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-white/25 text-white backdrop-blur transition hover:bg-white/50 md:flex">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
        </button>
        <button type="button" @click="next(); play()" aria-label="Next"
                class="absolute right-4 top-1/2 z-20 hidden h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-white/25 text-white backdrop-blur transition hover:bg-white/50 md:flex">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>
        </button>

        {{-- Titik --}}
        <div class="absolute inset-x-0 bottom-4 z-20 flex justify-center gap-2">
            @foreach($slides as $k => $slide)
                <button type="button" @click="go({{ $k }}); play()" aria-label="Slide {{ $k + 1 }}"
                        :class="i === {{ $k }} ? 'w-7 bg-white' : 'w-2.5 bg-white/50 hover:bg-white/80'"
                        class="h-2.5 rounded-full shadow transition-all duration-300"></button>
            @endforeach
        </div>
    @endif
</section>