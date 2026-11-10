@extends('layouts.app')
@section('title', $job->localized('title').' | PT Mirota KSM')

@php
    $input = 'mt-1 w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20';
@endphp

@section('content')
<x-page-header :title="$job->localized('title')" :label="__('nav.career')" />
<x-career-tabs />

<section class="bg-linear-to-b from-sky/70 to-white py-16">
    <div class="container mx-auto grid max-w-6xl gap-8 px-6 lg:grid-cols-3">

        {{-- Isi lowongan --}}
        <div class="space-y-8 lg:col-span-2">
            <div class="rounded-3xl bg-white p-8 shadow-lg">
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="rounded-full bg-accent px-3 py-1 font-bold text-white">{{ __('career.types.'.$job->type) }}</span>
                    @if($job->department)
                        <span class="rounded-full bg-primary/10 px-3 py-1 font-semibold text-primary">{{ $job->department }}</span>
                    @endif
                    @if($job->location)
                        <span class="text-slate-500">📍 {{ $job->location }}</span>
                    @endif
                </div>

                <h2 class="mt-6 text-2xl font-extrabold text-primary">{{ __('career.job.description') }}</h2>
                <div class="prose prose-slate mt-3 max-w-none prose-a:text-primary">{!! $job->html('description') !!}</div>

                @if(filled($job->localized('requirements')))
                    <h2 class="mt-8 text-2xl font-extrabold text-primary">{{ __('career.job.requirements') }}</h2>
                    <div class="prose prose-slate mt-3 max-w-none prose-a:text-primary">{!! $job->html('requirements') !!}</div>
                @endif
            </div>

            <a href="{{ route('career.jobs') }}" class="inline-block text-sm font-semibold text-primary hover:text-accent">← {{ __('career.job.back') }}</a>
        </div>

        {{-- Formulir lamaran --}}
        <div id="apply" class="scroll-mt-24 lg:sticky lg:top-28 lg:self-start">
            <div class="rounded-3xl bg-white p-8 shadow-lg">
                <h2 class="text-xl font-extrabold text-primary">{{ __('career.job.apply_title') }}</h2>

                @if($job->closing_date)
                    <p class="mt-1 text-xs text-slate-500">
                        {{ __('career.jobs.deadline') }}: {{ $job->closing_date->translatedFormat('d F Y') }}
                    </p>
                @endif

                @if(session('success'))
                    <div class="mt-4 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('career.apply', $job->slug) }}" enctype="multipart/form-data" class="mt-5 space-y-4">
                    @csrf

                    <div class="hidden" aria-hidden="true">
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div>
                        <label for="name" class="text-sm font-semibold text-slate-700">{{ __('contact.name') }} *</label>
                        <input id="name" name="name" value="{{ old('name') }}" required class="{{ $input }}">
                        @error('name') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="text-sm font-semibold text-slate-700">Email *</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="{{ $input }}">
                        @error('email') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="phone" class="text-sm font-semibold text-slate-700">{{ __('visit.phone') }} *</label>
                        <input id="phone" name="phone" value="{{ old('phone') }}" required class="{{ $input }}">
                        @error('phone') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="cv" class="text-sm font-semibold text-slate-700">{{ __('career.job.cv') }} *</label>
                        <input id="cv" type="file" name="cv" accept=".pdf,.doc,.docx" required
                               class="mt-1 block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-primary/10 file:px-4 file:py-2 file:font-semibold file:text-primary hover:file:bg-primary/20">
                        <p class="mt-1 text-xs text-slate-400">{{ __('career.job.cv_hint') }}</p>
                        @error('cv') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="cover_letter" class="text-sm font-semibold text-slate-700">{{ __('career.job.cover') }}</label>
                        <textarea id="cover_letter" name="cover_letter" rows="4" class="{{ $input }}">{{ old('cover_letter') }}</textarea>
                        @error('cover_letter') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
                    </div>

                    <p class="text-xs text-slate-500">
                        {{ __('career.job.privacy') }}
                        <a href="{{ route('privacy') }}" class="font-semibold text-primary underline">{{ __('footer.privacy') }}</a>.
                    </p>

                    <button type="submit" class="w-full rounded-lg bg-accent px-6 py-3 font-semibold text-white transition hover:brightness-110">
                        {{ __('career.job.submit') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection