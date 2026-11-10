@extends('layouts.app')
@section('title', __('visit.title').' | PT Mirota KSM')

@php
    $input = 'mt-1 w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20';
@endphp

@section('content')
<x-page-header :title="__('visit.title')" :subtitle="__('visit.subtitle')" :label="__('nav.visit')" />

{{-- Pengantar + yang didapat --}}
<section class="bg-linear-to-b from-sky/70 to-white py-20">
    <div class="container mx-auto max-w-6xl px-6">
        <x-draft-note />

        <div class="mx-auto max-w-3xl text-center">
            <h2 class="text-3xl font-extrabold text-primary md:text-4xl">{{ __('visit.intro_title') }}</h2>
            <p class="mt-4 text-lg text-slate-700">{{ __('visit.intro_text') }}</p>
        </div>

        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach(trans('visit.benefits') as $b)
                <div class="rounded-2xl bg-white p-6 shadow-md transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10 text-2xl">{{ $b['icon'] }}</div>
                    <h3 class="mt-4 text-lg font-bold text-primary-dark">{{ $b['title'] }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $b['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Galeri (carousel) --}}
@if($photos->isNotEmpty())
@php
    $slides = $photos->map(fn ($p) => [
        'src'     => asset('storage/'.$p->image),
        'caption' => $p->localized('caption'),
    ])->values();
@endphp

<section class="overflow-hidden bg-white py-20">
    <div class="container mx-auto max-w-6xl px-6">
        <h2 class="text-center text-3xl font-extrabold text-primary md:text-4xl">{{ __('visit.gallery_title') }}</h2>
        <div class="mx-auto mt-3 h-1 w-16 rounded-full bg-accent"></div>

        <div x-data="visitGallery(@js($slides))"
             @resize.window.debounce.200ms="measure()"
             @keydown.escape.window="close()"
             @keydown.arrow-right.window="lightbox !== null && lbNext()"
             @keydown.arrow-left.window="lightbox !== null && lbPrev()"
             @mouseenter="stop()" @mouseleave="start()"
             @touchstart.passive="tx = $event.touches[0].clientX; stop()"
             @touchend="swipe($event); start()"
             class="relative mt-12">

            {{-- Viewport + track --}}
            <div x-ref="viewport" class="-mx-2 overflow-hidden py-4">
                <div class="flex"
                     :style="`transform: translateX(-${x}px); transition: ${animate ? 'transform ' + duration + 'ms cubic-bezier(.22,.61,.36,1)' : 'none'}`">

                    <template x-for="item in items" :key="item.uid">
                        <div class="shrink-0 px-2" :style="`width: ${100 / perView}%`">
                            <button type="button" @click="open(item.orig)"
                                    class="group relative block aspect-[4/3] w-full overflow-hidden rounded-3xl shadow-lg ring-1 ring-black/5">
                                <img :src="item.src" :alt="item.caption || ''" draggable="false"
                                     class="h-full w-full object-cover transition duration-500 group-hover:scale-110">

                                <span class="pointer-events-none absolute inset-0 bg-linear-to-t from-black/70 via-transparent to-transparent"></span>

                                <span x-show="item.caption" x-text="item.caption"
                                      class="absolute inset-x-0 bottom-0 p-5 text-left text-sm font-semibold text-white"></span>

                                <span class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-lg text-primary opacity-0 shadow transition group-hover:opacity-100">⤢</span>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Panah di sisi foto (desktop) --}}
            <button type="button" @click="prev()" aria-label="Previous"
                    class="absolute left-2 top-1/2 z-10 hidden h-14 w-14 -translate-y-1/2 items-center justify-center rounded-full bg-white/95 text-primary shadow-xl ring-1 ring-black/5 backdrop-blur transition hover:scale-110 hover:bg-primary hover:text-white md:flex">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <button type="button" @click="next()" aria-label="Next"
                    class="absolute right-2 top-1/2 z-10 hidden h-14 w-14 -translate-y-1/2 items-center justify-center rounded-full bg-white/95 text-primary shadow-xl ring-1 ring-black/5 backdrop-blur transition hover:scale-110 hover:bg-primary hover:text-white md:flex">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>
            </button>

            {{-- Bar navigasi bawah (semua layar) --}}
            <div class="mt-6 flex items-center justify-center gap-4">
                <button type="button" @click="prev()" aria-label="Previous"
                        class="flex h-11 w-11 items-center justify-center rounded-full border-2 border-primary/20 bg-white text-primary transition hover:bg-primary hover:text-white">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                </button>

                <div class="flex items-center gap-2">
                    <template x-for="(s, i) in slides" :key="i">
                        <button type="button" @click="go(i)" :aria-label="'Slide ' + (i + 1)"
                                :class="cur === i ? 'w-8 bg-accent' : 'w-2.5 bg-primary/30 hover:bg-primary/60'"
                                class="h-2.5 rounded-full transition-all duration-300"></button>
                    </template>
                </div>

                <button type="button" @click="next()" aria-label="Next"
                        class="flex h-11 w-11 items-center justify-center rounded-full border-2 border-primary/20 bg-white text-primary transition hover:bg-primary hover:text-white">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>
                </button>
            </div>

            <p class="mt-3 text-center text-xs font-semibold tracking-widest text-slate-400"
               x-text="String(cur + 1).padStart(2, '0') + ' / ' + String(slides.length).padStart(2, '0')"></p>

            {{-- Lightbox --}}
            <div x-show="lightbox !== null" x-cloak x-transition.opacity
                 class="fixed inset-0 z-[60] flex items-center justify-center bg-black/90 p-4"
                 @click.self="close()">

                <button type="button" @click="close()" aria-label="Close"
                        class="absolute right-5 top-5 flex h-11 w-11 items-center justify-center rounded-full bg-white/15 text-2xl text-white transition hover:bg-white/30">✕</button>

                <button type="button" @click="lbPrev()" aria-label="Previous"
                        class="absolute left-4 flex h-12 w-12 items-center justify-center rounded-full bg-white/15 text-white transition hover:bg-white/30">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                </button>

                <figure class="max-w-5xl text-center">
                    <img :src="lightbox !== null ? slides[lightbox].src : ''" alt=""
                         class="mx-auto max-h-[80vh] max-w-full rounded-2xl shadow-2xl">
                    <figcaption class="mt-4 text-sm text-white/90">
                        <span x-text="lightbox !== null ? slides[lightbox].caption : ''"></span>
                        <span class="ml-2 text-white/50" x-text="lightbox !== null ? (lightbox + 1) + ' / ' + slides.length : ''"></span>
                    </figcaption>
                </figure>

                <button type="button" @click="lbNext()" aria-label="Next"
                        class="absolute right-4 flex h-12 w-12 items-center justify-center rounded-full bg-white/15 text-white transition hover:bg-white/30">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>
                </button>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Video --}}
@if($videos->isNotEmpty())
<section class="bg-sky/50 py-20">
    <div class="container mx-auto max-w-6xl px-6">
        <h2 class="text-center text-3xl font-extrabold text-primary md:text-4xl">{{ __('visit.video_title') }}</h2>

        <div class="mt-10 grid gap-8 {{ $videos->count() > 1 ? 'md:grid-cols-2' : 'mx-auto max-w-3xl' }}">
            @foreach($videos as $video)
                <div>
                    <div class="aspect-video overflow-hidden rounded-2xl border-4 border-white shadow-xl">
                        <iframe class="h-full w-full" loading="lazy"
                                src="https://www.youtube-nocookie.com/embed/{{ $video->youtube_id }}"
                                title="{{ $video->localized('title') }}"
                                allow="accelerometer; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <p class="mt-3 text-center font-semibold text-slate-700">{{ $video->localized('title') }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Instansi yang pernah berkunjung --}}
@if($institutions->isNotEmpty())
<section class="bg-white py-16">
    <div class="container mx-auto max-w-6xl px-6">
        <h2 class="text-center text-2xl font-extrabold text-primary md:text-3xl">{{ __('visit.institutions_title') }}</h2>

        <div class="mt-10 grid grid-cols-2 gap-5 md:grid-cols-4 lg:grid-cols-6">
            @foreach($institutions as $inst)
                <div class="flex h-28 items-center justify-center rounded-2xl border border-slate-100 bg-white p-4 text-center shadow-sm">
                    @if($inst->logo)
                        <img src="{{ asset('storage/'.$inst->logo) }}" alt="{{ $inst->name }}" class="max-h-full max-w-full object-contain">
                    @else
                        <span class="text-xs font-bold text-primary">{{ $inst->name }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Pengajuan --}}
<section id="form" class="scroll-mt-24 bg-linear-to-b from-white to-sky/60 py-20">
    <div class="container mx-auto grid max-w-6xl gap-8 px-6 lg:grid-cols-5">

        <div class="rounded-3xl bg-white p-8 shadow-lg lg:col-span-3">
            <h2 class="text-2xl font-extrabold text-primary">{{ __('visit.form_title') }}</h2>

            @if(session('success'))
                <div class="mt-4 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('visit.store') }}" class="mt-6 space-y-5">
                @csrf

                <div class="hidden" aria-hidden="true">
                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="institution" class="text-sm font-semibold text-slate-700">{{ __('visit.institution') }} *</label>
                        <input id="institution" name="institution" value="{{ old('institution') }}" required class="{{ $input }}">
                        @error('institution') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="institution_type" class="text-sm font-semibold text-slate-700">{{ __('visit.type') }} *</label>
                        <select id="institution_type" name="institution_type" required class="{{ $input }}">
                            @foreach(trans('visit.types') as $key => $label)
                                <option value="{{ $key }}" @selected(old('institution_type') === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('institution_type') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="visitors" class="text-sm font-semibold text-slate-700">{{ __('visit.visitors') }} *</label>
                        <input id="visitors" type="number" name="visitors" min="1" max="500" value="{{ old('visitors') }}" required class="{{ $input }}">
                        @error('visitors') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="contact_name" class="text-sm font-semibold text-slate-700">{{ __('visit.contact_name') }} *</label>
                        <input id="contact_name" name="contact_name" value="{{ old('contact_name') }}" required class="{{ $input }}">
                        @error('contact_name') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="phone" class="text-sm font-semibold text-slate-700">{{ __('visit.phone') }} *</label>
                        <input id="phone" name="phone" value="{{ old('phone') }}" required class="{{ $input }}">
                        @error('phone') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="text-sm font-semibold text-slate-700">Email *</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="{{ $input }}">
                        @error('email') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="preferred_date" class="text-sm font-semibold text-slate-700">{{ __('visit.date') }} *</label>
                        <input id="preferred_date" type="date" name="preferred_date" min="{{ now()->addDay()->toDateString() }}"
                               value="{{ old('preferred_date') }}" required class="{{ $input }}">
                        @error('preferred_date') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="message" class="text-sm font-semibold text-slate-700">{{ __('visit.message') }}</label>
                    <textarea id="message" name="message" rows="4" class="{{ $input }}">{{ old('message') }}</textarea>
                    @error('message') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
                </div>

                <p class="text-xs text-slate-500">
                    {{ __('contact.privacy_note') }}
                    <a href="{{ route('privacy') }}" class="font-semibold text-primary underline">{{ __('footer.privacy') }}</a>.
                </p>

                <button type="submit" class="rounded-lg bg-primary px-8 py-3 font-semibold text-white transition hover:bg-primary-dark">
                    {{ __('visit.submit') }}
                </button>
            </form>
        </div>

        <div class="space-y-6 lg:col-span-2">
            <div class="rounded-3xl bg-primary p-8 text-white shadow-lg">
                <h3 class="text-xl font-bold">{{ __('visit.rules_title') }}</h3>
                <ul class="mt-4 space-y-3 text-sm text-white/90">
                    @foreach(trans('visit.rules') as $rule)
                        <li class="flex gap-3"><span class="text-sky-200">✔</span><span>{{ $rule }}</span></li>
                    @endforeach
                </ul>
            </div>

            <div class="rounded-3xl bg-white p-8 shadow-lg">
                <h3 class="text-xl font-bold text-primary">{{ __('visit.steps_title') }}</h3>
                <ol class="mt-4 space-y-4">
                    @foreach(trans('visit.steps') as $i => $step)
                        <li class="flex gap-4">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-accent text-sm font-bold text-white">{{ $i + 1 }}</span>
                            <span class="pt-1 text-sm text-slate-700">{{ $step }}</span>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection