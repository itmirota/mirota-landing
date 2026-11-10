@extends('layouts.app')
@section('title', __('career.team.title').' | PT Mirota KSM')

@section('content')
<x-page-header :title="__('career.team.title')" :subtitle="__('career.team.subtitle')" :label="__('nav.career')" />
<x-career-tabs />

<section class="bg-linear-to-b from-sky/70 to-white py-20">
    <div class="container mx-auto max-w-6xl px-6">

        @if($members->isEmpty())
            <p class="text-center text-slate-500">{{ __('career.team.empty') }}</p>
        @else
            <div class="grid grid-cols-2 gap-6 md:grid-cols-3 lg:grid-cols-4">
                @foreach($members as $m)
                    <div class="group overflow-hidden rounded-3xl bg-white text-center shadow-md transition hover:-translate-y-1 hover:shadow-xl">
                        <div class="aspect-[4/5] overflow-hidden bg-linear-to-br from-primary to-primary-light">
                            @if($m->photo)
                                <img src="{{ asset('storage/'.$m->photo) }}" alt="{{ $m->name }}" loading="lazy"
                                     class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="flex h-full items-center justify-center text-6xl font-extrabold text-white/90">
                                    {{ mb_substr($m->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-primary-dark">{{ $m->name }}</h3>
                            <p class="mt-1 text-sm text-accent">{{ $m->localized('position') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection