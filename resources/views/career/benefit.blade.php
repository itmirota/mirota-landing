@extends('layouts.app')
@section('title', __('career.benefit.title').' | PT Mirota KSM')

@section('content')
<x-page-header :title="__('career.benefit.title')" :subtitle="__('career.benefit.subtitle')" :label="__('nav.career')" />
<x-career-tabs />

<section class="bg-linear-to-b from-sky/70 to-white py-20">
    <div class="container mx-auto max-w-6xl px-6">
        <x-draft-note />

        <div class="mx-auto max-w-3xl text-center">
            <h2 class="text-3xl font-extrabold text-primary md:text-4xl">{{ __('career.benefit.intro_title') }}</h2>
            <p class="mt-4 text-lg text-slate-700">{{ __('career.benefit.intro_text') }}</p>
        </div>

        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach(trans('career.benefit.items') as $item)
                <div class="rounded-2xl bg-white p-6 shadow-md transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10 text-2xl">{{ $item['icon'] }}</div>
                    <h3 class="mt-4 text-lg font-bold text-primary-dark">{{ $item['title'] }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $item['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-primary py-16 text-white">
    <div class="container mx-auto max-w-3xl px-6 text-center">
        <h2 class="text-3xl font-extrabold">{{ __('career.benefit.cta_title') }}</h2>
        <p class="mt-3 text-white/85">{{ __('career.benefit.cta_text') }}</p>
        <a href="{{ route('career.jobs') }}"
           class="mt-8 inline-block rounded-lg bg-accent px-8 py-3 font-semibold text-white transition hover:brightness-110">
            {{ __('career.benefit.cta_button') }}
        </a>
    </div>
</section>
@endsection