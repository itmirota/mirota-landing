@extends('layouts.app')
@section('title', __('about.vision.title').' | PT Mirota KSM')

@section('content')
<x-page-header :title="__('about.vision.title')" :subtitle="__('about.vision.subtitle')" />
<x-about-tabs />

<section class="bg-gray-50 py-16">
    <div class="container mx-auto max-w-5xl px-6">
        <x-draft-note />

        <div class="grid gap-6 md:grid-cols-2">
            <div class="rounded-2xl bg-primary p-8 text-white">
                <h2 class="text-2xl font-bold text-sky-200">{{ __('about.vision.vision_label') }}</h2>
                <p class="mt-3 text-lg">{{ __('about.vision.vision') }}</p>
            </div>

            <div class="rounded-2xl bg-white p-8 shadow-sm">
                <h2 class="text-2xl font-bold text-primary">{{ __('about.vision.mission_label') }}</h2>
                <ul class="mt-3 space-y-3 text-gray-700">
                    @foreach(trans('about.vision.missions') as $mission)
                        <li class="flex gap-3"><span class="mt-1 text-primary">✔</span><span>{{ $mission }}</span></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <h2 class="mt-16 text-center text-3xl font-bold text-gray-900">{{ __('about.vision.culture_label') }}</h2>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach(trans('about.vision.values') as $value)
                <div class="rounded-2xl bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <h3 class="text-lg font-bold text-primary">{{ $value['title'] }}</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ $value['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection