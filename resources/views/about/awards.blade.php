@extends('layouts.app')
@section('title', __('about.awards.title').' | PT Mirota KSM')

@section('content')
<x-page-header :title="__('about.awards.title')" :subtitle="__('about.awards.subtitle')" />
<x-about-tabs />

<section class="bg-gray-50 py-16">
    <div class="container mx-auto max-w-5xl px-6">
        <x-draft-note />

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach(trans('about.awards.items') as $award)
                <div class="rounded-2xl bg-white p-6 text-center shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="text-4xl">🏆</div>
                    <p class="mt-3 text-sm font-bold text-accent">{{ $award['year'] }}</p>
                    <h3 class="mt-1 font-bold text-gray-900">{{ $award['name'] }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ $award['giver'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection