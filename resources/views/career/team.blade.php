@extends('layouts.app')
@section('title', __('career.team.title').' | PT Mirota KSM')

@section('content')
<x-page-header :title="__('career.team.title')" :subtitle="__('career.team.subtitle')" :label="__('nav.career')" />
<x-career-tabs />

<section class="bg-white py-16 md:py-20">
    <div class="container mx-auto max-w-6xl px-6">

        @if($members->isEmpty())
            <p class="text-center text-slate-500">{{ __('career.team.empty') }}</p>
        @else
            <p class="mx-auto max-w-2xl text-center text-lg text-slate-600">{{ __('career.team.intro') }}</p>

            <div class="mt-14 flex flex-wrap justify-center gap-x-8 gap-y-12">
                @foreach($members as $m)
                    <div class="group w-40 text-center sm:w-52">

                        {{-- Foto bulat di atas lingkaran berwarna --}}
                        <div class="mx-auto h-36 w-36 overflow-hidden rounded-full bg-primary ring-4 ring-sky transition duration-300 group-hover:ring-accent sm:h-44 sm:w-44">
                            @if($m->photo)
                                <img src="{{ asset('storage/'.$m->photo) }}" alt="{{ $m->name }}" loading="lazy"
                                     class="h-full w-full object-cover object-top">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-5xl font-extrabold text-white/90">
                                    {{ mb_strtoupper(mb_substr($m->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <h3 class="mt-5 text-lg font-bold text-slate-900">{{ $m->name }}</h3>
                        <p class="mt-1 text-sm text-slate-500">{{ $m->localized('position') }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection