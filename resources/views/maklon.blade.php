@php
    $waNumber = preg_replace('/\D/', '', (string) config('company.maklon.whatsapp'));
    if (str_starts_with($waNumber, '0')) {
        $waNumber = '62'.substr($waNumber, 1);   // 08xx menjadi 628xx
    }
    $waLink = $waNumber ? 'https://wa.me/'.$waNumber.'?text='.rawurlencode(__('maklon.wa_message')) : null;
@endphp

@extends('layouts.app')
@section('title', __('maklon.title').' | PT Mirota KSM')

@section('content')
<x-page-header :title="__('maklon.title')" :subtitle="__('maklon.subtitle')" :label="__('nav.maklon')" />

{{-- Mengapa Memilih Kami (gambar dari tim maklon) --}}
@php $why = 'images/maklon/mengapa-memilih-kami.png'; @endphp
@if(file_exists(public_path($why)))
<section class="bg-linear-to-b from-sky/70 to-white pt-16 pb-4">
    <div class="container mx-auto max-w-6xl px-6">
        <h2 class="text-center text-3xl font-extrabold text-primary md:text-4xl">{{ __('maklon.why_title') }}</h2>

        <div class="mt-8 overflow-x-auto">
            <img src="{{ asset($why) }}" alt="{{ __('maklon.why_alt') }}" loading="lazy"
                 class="mx-auto h-auto w-full min-w-[720px]">
        </div>
        <p class="mt-2 text-center text-xs text-slate-400 md:hidden">{{ __('maklon.why_swipe') }}</p>

        {{-- Teks untuk pembaca layar dan mesin pencari --}}
        <dl class="sr-only">
            @foreach(trans('maklon.why_items') as $item)
                <dt>{{ $item['title'] }}</dt>
                <dd>{{ $item['text'] }}</dd>
            @endforeach
        </dl>
    </div>
</section>
@endif

{{-- Alur Maklon (gambar dari tim maklon) --}}
@php $flow = 'images/maklon/alur-maklon.png'; @endphp
@if(file_exists(public_path($flow)))
<section class="bg-white pt-16 pb-6">
    <div class="container mx-auto max-w-6xl px-6">
        <h2 class="text-center text-3xl font-extrabold text-primary md:text-4xl">{{ __('maklon.steps_title') }}</h2>

        <div class="mt-8 overflow-x-auto">
            <img src="{{ asset($flow) }}" alt="{{ __('maklon.flow_alt') }}" loading="lazy"
                 class="mx-auto h-auto w-full min-w-[720px]">
        </div>
        <p class="mt-2 text-center text-xs text-slate-400 md:hidden">{{ __('maklon.flow_swipe') }}</p>

        {{-- Teks untuk pembaca layar dan mesin pencari --}}
        <ol class="sr-only">
            @foreach(trans('maklon.steps') as $step)
                <li>{{ $step }}</li>
            @endforeach
        </ol>
    </div>
</section>
@endif

{{-- Klien / mitra --}}
@if($partners->isNotEmpty())
<section class="bg-white py-14">
    <div class="container mx-auto max-w-6xl px-6">
        <h2 class="text-center text-3xl font-extrabold text-primary md:text-4xl">{{ __('maklon.partners_title') }}</h2>

        <div class="mt-10 flex flex-wrap items-center justify-center gap-x-14 gap-y-8">
            @foreach($partners as $partner)
                @php $tag = $partner->website ? 'a' : 'div'; @endphp
                <{{ $tag }} @if($partner->website) href="{{ $partner->website }}" target="_blank" rel="noopener noreferrer" @endif
                    class="flex h-20 w-36 items-center justify-center transition hover:opacity-75">
                    @if($partner->logo)
                        <img src="{{ asset('storage/'.$partner->logo) }}" alt="{{ $partner->name }}" loading="lazy"
                             class="max-h-full max-w-full object-contain">
                    @else
                        <span class="text-center text-sm font-bold text-primary">{{ $partner->name }}</span>
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
<section class="bg-primary py-14 text-white">
    <div class="container mx-auto max-w-3xl px-6 text-center">
        <h2 class="text-3xl font-extrabold">{{ __('maklon.cta_title') }}</h2>
        <p class="mt-3 text-white/85">{{ __('maklon.cta_text') }}</p>

        <div class="mt-8 flex flex-wrap justify-center gap-4">
            @if($waLink)
                <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                   class="rounded-lg bg-[#25D366] px-8 py-3 font-semibold text-white transition hover:brightness-95">
                    {{ __('maklon.cta_whatsapp') }}
                </a>
            @endif
            <a href="{{ route('contact', ['type' => 'maklon']) }}"
               class="rounded-lg border border-white px-8 py-3 font-semibold transition hover:bg-white hover:text-primary-dark">
                {{ __('maklon.cta_form') }}
            </a>
        </div>
    </div>
</section>
@if($waLink)
    <x-whatsapp-float :href="$waLink" />
@endif
@endsection