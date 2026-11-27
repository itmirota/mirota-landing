@extends('layouts.app')
@section('title', __('career.jobs.title').' | PT Mirota KSM')

@section('content')
<x-page-header :title="__('career.jobs.title')" :subtitle="__('career.jobs.subtitle')" :label="__('nav.career')" />
<x-career-tabs />

<section class="bg-linear-to-b from-sky/70 to-white py-16">
    <div class="container mx-auto max-w-4xl px-6">

        {{-- Filter tipe --}}
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('career.jobs') }}"
               class="rounded-full px-5 py-2 text-sm font-semibold transition
                      {{ ! $type ? 'bg-primary text-white shadow' : 'bg-white text-primary shadow-sm hover:bg-primary/10' }}">
                {{ __('career.jobs.all') }}
            </a>

            @foreach(trans('career.types') as $key => $label)
                <a href="{{ route('career.jobs', ['tipe' => $key]) }}"
                   class="rounded-full px-5 py-2 text-sm font-semibold transition
                          {{ $type === $key ? 'bg-primary text-white shadow' : 'bg-white text-primary shadow-sm hover:bg-primary/10' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if($jobs->isEmpty())
            <div class="mt-12 rounded-3xl bg-white p-10 text-center shadow-md">
                <p class="text-4xl">📭</p>
                <p class="mt-3 font-semibold text-slate-700">{{ __('career.jobs.empty') }}</p>
                <p class="mt-1 text-sm text-slate-500">{{ __('career.jobs.empty_hint') }}</p>
                <a href="{{ route('contact') }}" class="mt-5 inline-block font-semibold text-primary underline">
                    {{ __('nav.contact') }}
                </a>
            </div>
        @else
            <div class="mt-8 space-y-4">
                @foreach($jobs as $job)
                    <a href="{{ route('career.job', $job->slug) }}"
                       class="group flex flex-col gap-4 rounded-2xl border-l-4 border-primary bg-white p-6 shadow-md transition hover:-translate-y-0.5 hover:border-accent hover:shadow-xl sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <h3 class="text-xl font-bold text-primary-dark group-hover:text-primary">
                                {{ $job->localized('title') }}
                            </h3>

                            {{-- Tipe dan departemen --}}
                            <div class="mt-2 flex flex-wrap items-center gap-2 text-xs">
                                <span class="rounded-full bg-accent/10 px-3 py-1 font-bold text-accent">
                                    {{ __('career.types.'.$job->type) }}
                                </span>

                                @if($job->department)
                                    <span class="rounded-full bg-primary/10 px-3 py-1 font-semibold text-primary">
                                        {{ $job->department }}
                                    </span>
                                @endif
                            </div>

                            {{-- Lokasi dan deadline --}}
                            <div class="mt-3 flex flex-wrap items-center gap-x-6 gap-y-1 text-sm">
                                @if($job->location)
                                    <span class="inline-flex items-center gap-1.5 text-slate-500">
                                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/>
                                            <circle cx="12" cy="10" r="3"/>
                                        </svg>
                                        {{ $job->location }}
                                    </span>
                                @endif

                                <x-closing-badge :job="$job" />
                            </div>
                        </div>

                        <span class="shrink-0 font-semibold text-primary">
                            {{ __('career.jobs.view') }} →
                        </span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
