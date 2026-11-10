@extends('layouts.app')
@section('title', __('about.history.title').' | PT Mirota KSM')

@php
    
    $heroPhoto = file_exists(public_path('images/history/gedung-lama.jpg'))
        ? 'images/history/gedung-lama.jpg'
        : 'images/building.jpg';

    $gallery = collect(['galeri-1.jpg', 'galeri-2.jpg', 'galeri-3.jpg'])
        ->filter(fn ($f) => file_exists(public_path("images/history/$f")));
@endphp

@section('content')
<x-page-header :title="__('about.history.title')" :subtitle="__('about.history.subtitle')" />
<x-about-tabs />

{{-- Cerita awal --}}
<section class="bg-linear-to-b from-sky/70 to-white py-20">
    <div class="container mx-auto grid items-center gap-12 px-6 lg:grid-cols-2">

        <div class="relative">
            <div class="absolute -bottom-4 -right-4 h-full w-full rounded-3xl bg-accent/20"></div>
            <img src="{{ asset($heroPhoto) }}" alt="PT Mirota KSM"
                 class="relative aspect-[4/3] w-full rounded-3xl border-4 border-white object-cover shadow-xl">
        </div>

        <div>
            <h2 class="text-3xl font-extrabold uppercase text-primary md:text-4xl">
                {{ __('about.history.heading') }}
            </h2>
            <p class="mt-5 text-lg leading-relaxed text-slate-700">{{ __('about.history.intro') }}</p>

            <div class="mt-8 grid grid-cols-3 gap-4">
                @foreach(trans('about.history.stats') as $stat)
                    <div class="rounded-2xl bg-white p-4 text-center shadow-md">
                        <p class="text-2xl font-extrabold text-accent md:text-3xl">{{ $stat['value'] }}</p>
                        <p class="mt-1 text-xs font-medium text-slate-500">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Arti nama --}}
<section class="bg-white pb-6">
    <div class="container mx-auto grid max-w-5xl gap-6 px-6 md:grid-cols-2">
        @foreach(trans('about.history.names') as $name)
            <div class="rounded-3xl bg-primary p-8 text-white shadow-lg">
                <h3 class="text-4xl font-extrabold">{{ $name['name'] }}</h3>
                <p class="mt-1 text-sm font-semibold uppercase tracking-wider text-sky-200">{{ $name['expand'] }}</p>
                <p class="mt-4 text-white/90">{{ $name['text'] }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- Timeline --}}
<section class="bg-white py-20">
    <div class="container mx-auto px-6">
        <h2 class="text-center text-3xl font-extrabold text-primary md:text-4xl">
            {{ __('about.history.timeline_title') }}
        </h2>

        <div class="relative mx-auto mt-14 max-w-5xl">
            <div class="absolute left-4 top-0 h-full w-0.5 bg-primary/20 md:left-1/2 md:-translate-x-1/2"></div>

            @foreach(trans('about.history.timeline') as $i => $item)
                <div class="relative mb-10 pl-12 md:w-1/2 md:pl-0
                            {{ $i % 2 === 0 ? 'md:pr-12 md:text-right' : 'md:ml-auto md:pl-12' }}">

                    <span class="absolute top-7 left-4 h-5 w-5 -translate-x-1/2 rounded-full border-4 border-white bg-accent shadow
                                 {{ $i % 2 === 0 ? 'md:left-auto md:right-0 md:translate-x-1/2' : 'md:left-0' }}"></span>

                    <div class="rounded-2xl border-t-4 border-primary bg-white p-6 shadow-md transition hover:-translate-y-1 hover:shadow-xl">
                        <span class="inline-block rounded-full bg-accent px-3 py-1 text-xs font-bold text-white">
                            {{ $item['year'] }}
                        </span>
                        <h3 class="mt-3 text-xl font-bold text-primary-dark">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $item['text'] }}</p>

                        @if(($item['draft'] ?? false) && app()->environment('local'))
                            <span class="mt-3 inline-block rounded bg-yellow-100 px-2 py-0.5 text-xs text-yellow-800">DRAF</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Galeri foto lama (tampil otomatis kalau fotonya ada) --}}
@if($gallery->isNotEmpty())
<section class="bg-sky/50 py-16">
    <div class="container mx-auto px-6">
        <h2 class="text-center text-2xl font-extrabold text-primary md:text-3xl">{{ __('about.history.gallery') }}</h2>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($gallery as $file)
                <img src="{{ asset("images/history/$file") }}" alt=""
                     class="aspect-[4/3] w-full rounded-2xl border-4 border-white object-cover shadow-lg">
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection