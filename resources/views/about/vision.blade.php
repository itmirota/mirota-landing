
@extends('layouts.app')
@section('title', __('about.vision.title').' | PT Mirota KSM')

@section('content')
<x-page-header
    :title="__('about.vision.title')"
    :subtitle="__('about.vision.subtitle')"
/>

<x-about-tabs />

<section class="relative overflow-hidden bg-slate-50 py-20">

    {{-- Dekorasi background --}}
    <div class="pointer-events-none absolute -right-32 top-20 h-80 w-80 rounded-full bg-primary/5 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-32 bottom-20 h-80 w-80 rounded-full bg-accent/10 blur-3xl"></div>

    <div class="relative mx-auto max-w-6xl px-6">

        {{-- INTRO --}}
        <div class="mx-auto mb-14 max-w-2xl text-center">
            <span class="text-sm font-bold uppercase tracking-[0.25em] text-accent">
                PT Mirota KSM
            </span>

            <h2 class="mt-3 text-3xl font-extrabold text-primary-dark md:text-4xl">
                {{ __('about.vision.vision_label') }}
                <span class="text-accent">&</span>
                {{ __('about.vision.mission_label') }}
            </h2>

            <div class="mx-auto mt-5 h-1 w-20 rounded-full bg-accent"></div>
        </div>


        {{-- VISI --}}
        <div class="mb-8 rounded-3xl bg-primary p-8 text-white shadow-xl md:p-12">



            <div class="relative z-10 grid items-center gap-8 md:grid-cols-[180px_1fr]">

                <div class="flex justify-center md:justify-start">
                    <div class="flex h-28 w-28 items-center justify-center rounded-3xl border border-white/20 bg-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-sky-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.5-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.5 7.5-9.75 7.5S2.25 12 2.25 12z"/>
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </div>
                </div>

                <div>
                    <span class="text-sm font-bold uppercase tracking-[0.2em] text-sky-200">
                        Our Vision
                    </span>

                    <h3 class="mt-2 text-2xl font-extrabold md:text-3xl">
                        {{ __('about.vision.vision_label') }}
                    </h3>

                    <p class="mt-5 max-w-3xl text-base leading-8 text-white/90 md:text-lg">
                        {{ __('about.vision.vision') }}
                    </p>
                </div>

            </div>
        </div>


        {{-- MISI --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm md:p-12">

            <div class="mb-9 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <span class="text-sm font-bold uppercase tracking-[0.2em] text-accent">
                        Our Mission
                    </span>

                    <h3 class="mt-2 text-2xl font-extrabold text-primary-dark md:text-3xl">
                        {{ __('about.vision.mission_label') }}
                    </h3>
                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary/5 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                    </svg>
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                @foreach(trans('about.vision.missions') as $i => $mission)
                    <div class="group flex gap-5 rounded-2xl border border-slate-100 bg-slate-50 p-6 transition duration-300 hover:-translate-y-1 hover:border-primary/20 hover:bg-white hover:shadow-lg">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary text-sm font-extrabold text-white transition group-hover:bg-accent">
                            {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                        </div>

                        <p class="text-sm leading-7 text-slate-700 md:text-base">
                            {{ $mission }}
                        </p>

                    </div>
                @endforeach
            </div>

        </div>


        {{-- BUDAYA PERUSAHAAN --}}
        <div class="mt-20">

            <div class="mx-auto mb-10 max-w-2xl text-center">
                <span class="text-sm font-bold uppercase tracking-[0.2em] text-accent">
                    Company Values
                </span>

                <h2 class="mt-3 text-3xl font-extrabold text-primary-dark md:text-4xl">
                    {{ __('about.vision.culture_label') }}
                </h2>

                <div class="mx-auto mt-5 h-1 w-20 rounded-full bg-accent"></div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach(trans('about.vision.values') as $i => $value)
                    <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-7 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl">

                        <div class="absolute right-5 top-3 text-5xl font-black text-slate-100 transition group-hover:text-primary/10">
                            {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                        </div>

                        <div class="relative z-10">
                            <div class="mb-5 h-1 w-12 rounded-full bg-accent transition-all duration-300 group-hover:w-20"></div>

                            <h3 class="text-xl font-bold text-primary-dark">
                                {{ $value['title'] }}
                            </h3>

                            <p class="mt-3 text-sm leading-7 text-slate-600">
                                {{ $value['text'] }}
                            </p>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>

    </div>
</section>
@endsection
