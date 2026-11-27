@extends('layouts.app')
@section('title', $job->localized('title').' | PT Mirota KSM')

@php
    $box     = 'rounded-lg border border-slate-200 bg-white px-5 shadow-sm transition focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/20';
    $field   = 'w-full bg-transparent py-4 text-slate-700 outline-none placeholder:text-slate-500';
    $inner   = 'w-full bg-transparent pb-2.5 pt-0.5 text-slate-700 outline-none';
    $label   = 'block pt-2 text-xs text-slate-500';
    $fileCls = $inner.' text-sm file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-1.5 file:text-slate-700';
@endphp

@section('content')
<x-page-header :title="$job->localized('title')" :label="__('nav.career')" />
<x-career-tabs />

{{-- Deskripsi lowongan --}}
<section class="bg-linear-to-b from-sky/70 to-white py-14">
    <div class="container mx-auto max-w-4xl px-6">
        <div class="rounded-3xl bg-white p-8 shadow-lg">
        <div class="flex flex-wrap items-center gap-2 text-xs">
            <span class="rounded-full bg-accent px-3 py-1 font-bold text-white">{{ __('career.types.'.$job->type) }}</span>
            @if($job->department)
                <span class="rounded-full bg-primary/10 px-3 py-1 font-semibold text-primary">{{ $job->department }}</span>
            @endif
        </div>

        <div class="mt-3 flex flex-wrap items-center gap-x-6 gap-y-1 text-sm">
            @if($job->location)
                <span class="inline-flex items-center gap-1.5 text-slate-500">
                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/>
                    </svg>
                    {{ $job->location }}
                </span>
            @endif

            <x-closing-badge :job="$job" />

            @if($job->closing_date)
                <span class="text-slate-500">
                    {{ __('career.jobs.deadline') }}: {{ \Illuminate\Support\Carbon::parse($job->closing_date)->translatedFormat('d F Y') }}
                </span>
            @endif
        </div>

            <h2 class="mt-6 text-2xl font-extrabold text-primary">{{ __('career.job.description') }}</h2>
            <div class="prose prose-slate mt-3 max-w-none prose-a:text-primary">{!! $job->html('description') !!}</div>

            @if(filled($job->localized('requirements')))
                <h2 class="mt-8 text-2xl font-extrabold text-primary">{{ __('career.job.requirements') }}</h2>
                <div class="prose prose-slate mt-3 max-w-none prose-a:text-primary">{!! $job->html('requirements') !!}</div>
            @endif

            <div class="mt-8 flex flex-wrap items-center gap-4">
                <a href="#apply" class="rounded-lg bg-accent px-6 py-3 font-semibold text-white transition hover:brightness-110">
                    {{ __('career.job.apply_title') }}
                </a>
                <a href="{{ route('career.jobs') }}" class="text-sm font-semibold text-primary hover:text-accent">← {{ __('career.job.back') }}</a>
            </div>
        </div>
    </div>
</section>

{{-- Formulir kerja --}}
<section id="apply" class="scroll-mt-24 bg-linear-to-b from-white to-sky/60 py-16"
         x-data="{
             sending: false,
             fileErr: { cv: '', diploma: '', attachment: '' },
             names: @js(['cv' => __('career.job.cv_name'), 'diploma' => __('career.job.diploma_name'), 'attachment' => __('career.job.attachment_name')]),
             msg: @js(['big' => __('career.job.file_too_big'), 'type' => __('career.job.file_bad_type')]),
             checkFile(event, key) {
                 const input = event.target;
                 const file = input.files[0];
                 this.fileErr[key] = '';
                 if (!file) return;
                 const name = this.names[key];
                 if (file.name.split('.').pop().toLowerCase() !== 'pdf') {
                     this.fileErr[key] = this.msg.type.replace(':name', name);
                     input.value = '';
                 } else if (file.size > 2 * 1048576) {
                     this.fileErr[key] = this.msg.big.replace(':name', name).replace(':size', (file.size / 1048576).toFixed(1));
                     input.value = '';
                 }
             },
             onSubmit(event) {
                 if (Object.values(this.fileErr).some(Boolean)) {
                     event.preventDefault();
                     return;
                 }
                 this.sending = true;
             }
         }">

    <div class="container mx-auto max-w-5xl px-6">
        <h2 class="text-center text-3xl font-extrabold text-primary md:text-4xl">{{ __('career.job.form_title') }}</h2>

        @if(session('success'))
            <div class="mt-6 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
        @endif

        {{-- Ringkasan error --}}
        @if($errors->any())
            <div x-init="$nextTick(() => $el.scrollIntoView({ behavior: 'smooth', block: 'start' }))"
                 class="mt-6 scroll-mt-28 rounded-lg border border-red-300 bg-red-50 p-4 text-sm text-red-800" role="alert">
                <p class="font-bold">{{ __('career.job.error_summary') }}</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <p class="mt-3 text-xs text-red-700">{{ __('career.job.error_files_hint') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('career.apply', $job->slug) }}" enctype="multipart/form-data"
              @submit="onSubmit($event)" class="mt-8">
            @csrf

            <div class="hidden" aria-hidden="true">
                <input type="text" name="website" tabindex="-1" autocomplete="off">
            </div>

            <div class="grid gap-4 md:grid-cols-2">

                {{-- Kolom kiri --}}
                <div class="space-y-4">
                    {{-- Posisi terisi otomatis dari lowongan yang dibuka --}}
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-5 shadow-sm">
                        <span class="{{ $label }}">{{ __('career.job.position') }}</span>
                        <p class="pb-2.5 pt-0.5 font-semibold text-slate-800">{{ $job->localized('title') }}</p>
                    </div>

                   <x-float-input name="name" :label="__('career.job.full_name')" required />

                    <x-float-textarea name="address" :label="__('career.job.address')" rows="2" required />

                    <x-float-input name="email" type="email" :label="__('career.job.email')" required />

                    <x-float-input name="phone" :label="__('career.job.whatsapp')" inputmode="tel" required />
                </div>

                {{-- Kolom kanan: berkas --}}
                <div class="space-y-4">
                    <div>
                        <div class="{{ $box }}" :class="fileErr.cv && 'border-red-400 ring-2 ring-red-100'">
                            <label for="cv" class="{{ $label }}">{{ __('career.job.cv') }}</label>
                            <input id="cv" type="file" name="cv" accept=".pdf,application/pdf" required
                                   @change="checkFile($event, 'cv')" class="{{ $fileCls }}">
                        </div>
                        <p class="mt-1 text-xs text-slate-500">{{ __('career.job.file_hint') }}</p>
                        <p x-show="fileErr.cv" x-cloak x-text="fileErr.cv" role="alert"
                           class="mt-1.5 rounded-md bg-red-50 px-3 py-2 text-sm font-medium text-red-700"></p>
                        <x-form-error name="cv" />
                    </div>

                    <div>
                        <div class="{{ $box }}" :class="fileErr.diploma && 'border-red-400 ring-2 ring-red-100'">
                            <label for="diploma" class="{{ $label }}">{{ __('career.job.diploma') }}</label>
                            <input id="diploma" type="file" name="diploma" accept=".pdf,application/pdf" required
                                   @change="checkFile($event, 'diploma')" class="{{ $fileCls }}">
                        </div>
                        <p class="mt-1 text-xs text-slate-500">{{ __('career.job.file_hint') }}</p>
                        <p x-show="fileErr.diploma" x-cloak x-text="fileErr.diploma" role="alert"
                           class="mt-1.5 rounded-md bg-red-50 px-3 py-2 text-sm font-medium text-red-700"></p>
                        <x-form-error name="diploma" />
                    </div>

                    <div>
                        <div class="{{ $box }}" :class="fileErr.attachment && 'border-red-400 ring-2 ring-red-100'">
                            <label for="attachment" class="{{ $label }}">{{ __('career.job.attachment') }}</label>
                            <input id="attachment" type="file" name="attachment" accept=".pdf,application/pdf"
                                   @change="checkFile($event, 'attachment')" class="{{ $fileCls }}">
                        </div>
                        <p class="mt-1 text-xs text-slate-500">{{ __('career.job.file_hint') }}</p>
                        <p x-show="fileErr.attachment" x-cloak x-text="fileErr.attachment" role="alert"
                           class="mt-1.5 rounded-md bg-red-50 px-3 py-2 text-sm font-medium text-red-700"></p>
                        <x-form-error name="attachment" />
                    </div>
                </div>
            </div>
            <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-slate-500 sm:max-w-xl">
                    {{ __('career.job.privacy') }}
                    <a href="{{ route('privacy') }}" class="font-semibold text-primary underline">{{ __('footer.privacy') }}</a>.
                </p>

                <button type="submit" :disabled="sending"
                        class="w-full shrink-0 rounded-lg bg-primary px-8 py-3 font-semibold text-white transition hover:bg-primary-dark disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto">
                    <span x-show="!sending">{{ __('career.job.submit') }}</span>
                    <span x-show="sending" x-cloak>{{ __('career.job.sending') }}</span>
                </button>
            </div>
        </form>
    </div>
</section>
@endsection