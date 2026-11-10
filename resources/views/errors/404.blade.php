@extends('layouts.app')
@section('title', '404 | PT Mirota KSM')

@section('content')
<section class="flex min-h-screen items-center bg-linear-to-b from-sky/70 to-white pt-28">
    <div class="container mx-auto max-w-xl px-6 text-center">
        <p class="text-8xl font-extrabold text-primary">404</p>
        <h1 class="mt-4 text-2xl font-bold text-primary-dark">{{ __('errors.not_found_title') }}</h1>
        <p class="mt-3 text-slate-600">{{ __('errors.not_found_text') }}</p>
        <a href="{{ route('home', ['locale' => in_array(app()->getLocale(), ['id','en']) ? app()->getLocale() : 'id']) }}"
           class="mt-8 inline-block rounded-lg bg-primary px-8 py-3 font-semibold text-white transition hover:bg-primary-dark">
            {{ __('errors.back_home') }}
        </a>
    </div>
</section>
@endsection