@extends('layouts.app')
@section('title', __('about.quality.title').' | PT Mirota KSM')

@section('content')
<x-page-header :title="__('about.quality.title')" :subtitle="__('about.quality.subtitle')" />
<x-about-tabs />

<section class="bg-gray-50 py-16">
    <div class="container mx-auto max-w-4xl px-6">
       

        <div class="rounded-2xl bg-white p-8 shadow-sm">
            <p class="text-lg text-gray-700">{{ __('about.quality.statement') }}</p>
            <ul class="mt-6 space-y-3 text-gray-700">
                @foreach(trans('about.quality.commitments') as $c)
                    <li class="flex gap-3"><span class="mt-1 text-primary">✔</span><span>{{ $c }}</span></li>
                @endforeach
            </ul>
        </div>

        <h2 class="mt-14 text-2xl font-bold text-gray-900">{{ __('about.quality.cert_title') }}</h2>
        <div class="mt-6 grid gap-6 md:grid-cols-2">
            @foreach(trans('about.quality.certs') as $cert)
                <div class="rounded-2xl border-l-4 border-primary bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-primary">{{ $cert['name'] }}</h3>
                    <p class="mt-1 text-sm text-gray-600">{{ $cert['scope'] }}</p>
                    <p class="mt-3 text-xs text-gray-400">{{ $cert['number'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection