@extends('layouts.app')
@section('title', __('maklon.title').' | PT Mirota KSM')

@section('content')
<x-page-header :title="__('maklon.title')" :subtitle="__('maklon.subtitle')" :label="__('nav.maklon')" />

{{-- Pengantar + keunggulan --}}
<section class="bg-linear-to-b from-sky/70 to-white py-20">
    <div class="container mx-auto max-w-6xl px-6">
        <x-draft-note />

        <div class="mx-auto max-w-3xl text-center">
            <h2 class="text-3xl font-extrabold text-primary md:text-4xl">{{ __('maklon.intro_title') }}</h2>
            <p class="mt-4 text-lg text-slate-700">{{ __('maklon.intro_text') }}</p>

            <div class="mt-6 flex flex-wrap justify-center gap-3">
                @foreach(trans('maklon.products') as $item)
                    <span class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-primary shadow">{{ $item }}</span>
                @endforeach
            </div>
        </div>

        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach(trans('maklon.advantages') as $adv)
                <div class="rounded-2xl bg-white p-6 shadow-md transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10 text-2xl">{{ $adv['icon'] }}</div>
                    <h3 class="mt-4 text-lg font-bold text-primary-dark">{{ $adv['title'] }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $adv['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Alur kerja sama --}}
<section class="bg-white py-20">
    <div class="container mx-auto max-w-6xl px-6">
        <h2 class="text-center text-3xl font-extrabold text-primary md:text-4xl">{{ __('maklon.steps_title') }}</h2>

        <div class="relative mt-14 grid gap-8 md:grid-cols-5">
            <div class="absolute left-0 right-0 top-7 hidden h-0.5 bg-primary/20 md:block"></div>

            @foreach(trans('maklon.steps') as $i => $step)
                <div class="relative text-center">
                    <div class="relative mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-accent text-xl font-extrabold text-white shadow-lg ring-4 ring-white">
                        {{ $i + 1 }}
                    </div>
                    <h3 class="mt-4 font-bold text-primary-dark">{{ $step['title'] }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $step['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Mitra --}}
@if($partners->isNotEmpty())
<section class="bg-sky/50 py-16">
    <div class="container mx-auto max-w-6xl px-6">
        <h2 class="text-center text-2xl font-extrabold text-primary md:text-3xl">{{ __('maklon.partners_title') }}</h2>

        <div class="mt-10 grid grid-cols-2 gap-5 md:grid-cols-4">
            @foreach($partners as $partner)
                @php $tag = $partner->website ? 'a' : 'div'; @endphp
                <{{ $tag }} @if($partner->website) href="{{ $partner->website }}" target="_blank" rel="noopener" @endif
                    class="flex h-28 items-center justify-center rounded-2xl bg-white p-4 text-center shadow-md transition hover:shadow-xl">
                    @if($partner->logo)
                        <img src="{{ asset('storage/'.$partner->logo) }}" alt="{{ $partner->name }}" class="max-h-full max-w-full object-contain">
                    @else
                        <span class="text-sm font-bold text-primary">{{ $partner->name }}</span>
                    @endif
                </{{ $tag }}>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Video --}}
@if($videos->isNotEmpty())
<section class="bg-white py-20">
    <div class="container mx-auto max-w-6xl px-6">
        <h2 class="text-center text-3xl font-extrabold text-primary md:text-4xl">{{ __('maklon.video_title') }}</h2>

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

{{-- Testimoni --}}
@if($testimonials->isNotEmpty())
<section class="bg-linear-to-b from-white to-sky/60 py-20">
    <div class="container mx-auto max-w-6xl px-6">
        <h2 class="text-center text-3xl font-extrabold text-primary md:text-4xl">{{ __('maklon.testimonial_title') }}</h2>

        <div class="mt-12 grid gap-6 md:grid-cols-2">
            @foreach($testimonials as $t)
                <figure class="relative rounded-3xl bg-white p-8 shadow-lg">
                    <span class="absolute right-6 top-2 text-7xl font-black text-accent/20">”</span>
                    <blockquote class="relative text-slate-700">{{ $t->localized('quote') }}</blockquote>
                    <figcaption class="mt-6 flex items-center gap-4">
                        @if($t->photo)
                            <img src="{{ asset('storage/'.$t->photo) }}" alt="{{ $t->name }}" class="h-12 w-12 rounded-full object-cover">
                        @else
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary text-lg font-bold text-white">
                                {{ mb_substr($t->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <p class="font-bold text-primary-dark">{{ $t->name }}</p>
                            <p class="text-sm text-slate-500">{{ collect([$t->position, $t->company])->filter()->join(', ') }}</p>
                        </div>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Ajakan --}}
<section class="bg-primary py-16 text-white">
    <div class="container mx-auto max-w-3xl px-6 text-center">
        <h2 class="text-3xl font-extrabold">{{ __('maklon.cta_title') }}</h2>
        <p class="mt-3 text-white/85">{{ __('maklon.cta_text') }}</p>
        <a href="{{ route('contact', ['type' => 'maklon']) }}"
           class="mt-8 inline-block rounded-lg bg-accent px-8 py-3 font-semibold text-white transition hover:brightness-110">
            {{ __('maklon.cta_button') }}
        </a>
    </div>
</section>
@endsection