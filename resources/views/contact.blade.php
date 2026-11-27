@extends('layouts.app')
@section('title', __('contact.title').' | PT Mirota KSM')

@php
    $co = config('company');
    $input = 'mt-1 w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20';
    $channels = [
        'customer_care' => ['icon' => '🎧', 'title' => __('contact.cs_title'), 'text' => __('contact.cs_text')],
        'maklon'        => ['icon' => '🏭', 'title' => __('contact.maklon_title'), 'text' => __('contact.maklon_text')],
    ];
@endphp

@section('content')
<x-page-header :title="__('contact.title')" :subtitle="__('contact.subtitle')" :label="__('nav.contact')" />

<section class="bg-linear-to-b from-sky/70 to-white py-16">
    <div class="container mx-auto max-w-6xl px-6">




{{-- Dua kanal kontak --}}
<div class="grid items-stretch gap-6 md:grid-cols-2">
    @foreach($channels as $key => $ch)
        @php
            $c = $co[$key];
            $message = __('contact.whatsapp_messages.' . $key);
        @endphp

        <div class="flex h-full flex-col rounded-3xl bg-white p-8 shadow-lg transition duration-300 hover:-translate-y-1 hover:shadow-xl">



            {{-- Ikon dan judul --}}
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-2xl">
                    {{ $ch['icon'] }}
                </div>

                <h2 class="text-2xl font-extrabold text-primary">
                    {{ $ch['title'] }}
                </h2>
            </div>

            {{-- Deskripsi --}}
            <p class="mt-2 min-h-[3rem] text-sm leading-relaxed text-slate-600">
                {{ $ch['text'] }}
            </p>

            
{{-- Informasi kontak --}}
<ul class="mt-4 space-y-3 text-sm">
    <li class="flex items-center gap-3">
        <span class="text-base">📞</span>
        <a href="tel:{{ $c['phone'] }}"
           class="font-semibold text-slate-700 transition hover:text-primary">
            {{ $c['phone'] }}
        </a>
    </li>

    <li class="flex items-center gap-3">
        <span class="text-base">✉️</span>
        <a href="mailto:{{ $c['email'] }}"
           class="font-semibold text-slate-700 transition hover:text-primary">
            {{ $c['email'] }}
        </a>
    </li>
</ul>

{{-- Tombol WhatsApp --}}
@if(filled($c['whatsapp']))
    <div class="mt-auto pt-7">
        <a href="https://wa.me/{{ preg_replace('/\D/', '', $c['whatsapp']) }}?text={{ urlencode($message) }}"
           target="_blank"
           rel="noopener noreferrer"
           class="inline-flex items-center justify-center gap-2.5 rounded-xl bg-[#25D366] px-6 py-3 text-sm font-bold text-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:bg-[#1ebe5d] hover:shadow-lg">

            {{-- Ikon WhatsApp SVG --}}
            <svg xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 24 24"
                 fill="currentColor"
                 class="h-5 w-5 shrink-0">
                <path d="M20.52 3.48A11.86 11.86 0 0 0 12.05 0C5.48 0 .14 5.34.14 11.91c0 2.1.55 4.15 1.59 5.96L0 24l6.28-1.65a11.9 11.9 0 0 0 5.76 1.47h.01c6.56 0 11.91-5.34 11.91-11.91 0-3.18-1.24-6.17-3.44-8.43ZM12.05 21.8a9.9 9.9 0 0 1-5.05-1.38l-.36-.21-3.73.98.99-3.64-.24-.37a9.85 9.85 0 0 1-1.52-5.27c0-5.47 4.45-9.91 9.92-9.91a9.84 9.84 0 0 1 7.02 2.91 9.84 9.84 0 0 1 2.9 7.01c0 5.47-4.45 9.88-9.93 9.88Zm5.44-7.41c-.3-.15-1.77-.87-2.05-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.8-1.49-1.78-1.67-2.08-.17-.3-.02-.46.13-.61.14-.13.3-.35.45-.52.15-.18.2-.3.3-.5.1-.2.05-.38-.02-.53-.08-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.49s1.07 2.89 1.22 3.09c.15.2 2.1 3.2 5.08 4.49.71.31 1.27.5 1.7.64.71.23 1.35.2 1.86.12.57-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.13-.27-.2-.57-.35Z"/>
            </svg>

            {{ __('contact.whatsapp') }}
        </a>
    </div>
@endif


        </div>
    @endforeach
</div>



        {{-- Formulir + alamat --}}
        <div class="mt-12 grid gap-8 lg:grid-cols-5">

            <div class="rounded-3xl bg-white p-8 shadow-lg lg:col-span-3">
                <h2 class="text-2xl font-extrabold text-primary">{{ __('contact.form_title') }}</h2>

                @if(session('success'))
                    <div class="mt-4 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}" class="mt-6 space-y-5">
                    @csrf

                    {{-- Honeypot (disembunyikan dari manusia) --}}
                    <div class="hidden" aria-hidden="true">
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    {{-- Jenis pesan --}}
                    <div>
                        <p class="text-sm font-semibold text-slate-700">{{ __('contact.type_label') }}</p>
                        <div class="mt-2 grid gap-3 sm:grid-cols-2">
                            @foreach($channels as $key => $ch)
                                <label class="cursor-pointer">
                                    <input type="radio" name="type" value="{{ $key }}" class="peer sr-only"
                                           @checked(old('type', request('type', 'customer_care')) === $key)>
                                    <div class="rounded-xl border-2 border-slate-200 px-4 py-3 text-sm font-semibold transition peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary">
                                        {{ $ch['icon'] }} {{ $ch['title'] }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <x-form-error name="$1" />
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="text-sm font-semibold text-slate-700">{{ __('contact.name') }} *</label>
                            <input id="name" name="name" value="{{ old('name') }}" required class="{{ $input }}">
                            <x-form-error name="$1" />
                        </div>
                        <div>
                            <label for="email" class="text-sm font-semibold text-slate-700">Email *</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="{{ $input }}">
                            <x-form-error name="$1" />
                        </div>
                        <div>
                            <label for="phone" class="text-sm font-semibold text-slate-700">{{ __('contact.phone') }}</label>
                            <input id="phone" name="phone" value="{{ old('phone') }}" class="{{ $input }}">
                            <x-form-error name="$1" />
                        </div>
                        <div>
                            <label for="company" class="text-sm font-semibold text-slate-700">{{ __('contact.company') }}</label>
                            <input id="company" name="company" value="{{ old('company') }}" class="{{ $input }}">
                        </div>
                    </div>

                    <div>
                        <label for="message" class="text-sm font-semibold text-slate-700">{{ __('contact.message') }} *</label>
                        <textarea id="message" name="message" rows="5" required class="{{ $input }}">{{ old('message') }}</textarea>
                        <x-form-error name="$1" />
                    </div>

                    <p class="text-xs text-slate-500">
                        {{ __('contact.privacy_note') }}
                        <a href="{{ route('privacy') }}" class="font-semibold text-primary underline">{{ __('footer.privacy') }}</a>.
                    </p>

                    {{-- Tombol Kirim Pesan --}}
                    <div class="flex justify-end">
                        <button type="submit"
                                class="rounded-lg bg-primary px-8 py-3 font-semibold text-white transition hover:bg-primary-dark">
                            {{ __('contact.submit') }}
                        </button>
                    </div>
                </form>
            </div>

            <div class="space-y-6 lg:col-span-2">
                <div class="rounded-3xl bg-primary p-8 text-white shadow-lg">
                    <h3 class="text-xl font-bold">{{ __('contact.address_title') }}</h3>
                    <p class="mt-3 text-sm text-white/90">{{ $co['name'] }}<br>{{ $co['address'] }}</p>
                    <p class="mt-4 text-sm text-sky-200">{{ __('contact.hours') }}</p>
                </div>

                <iframe class="h-72 w-full rounded-3xl border-0 shadow-lg" loading="lazy"
                        title="{{ __('contact.address_title') }}"
                        src="https://www.google.com/maps?q={{ urlencode($co['address']) }}&output=embed"></iframe>
            </div>
        </div>
    </div>
</section>
@endsection