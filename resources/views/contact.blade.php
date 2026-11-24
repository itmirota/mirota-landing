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
        <div class="grid gap-6 md:grid-cols-2">
            @foreach($channels as $key => $ch)
                @php $c = $co[$key]; @endphp
                <div class="rounded-3xl bg-white p-8 shadow-lg">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary/10 text-3xl">{{ $ch['icon'] }}</div>
                    <h2 class="mt-4 text-2xl font-extrabold text-primary">{{ $ch['title'] }}</h2>
                    <p class="mt-2 text-sm text-slate-600">{{ $ch['text'] }}</p>

                    <ul class="mt-5 space-y-2 text-sm">
                        <li>📞 <a href="tel:{{ $c['phone'] }}" class="font-semibold hover:text-accent">{{ $c['phone'] }}</a></li>
                        <li>✉️ <a href="mailto:{{ $c['email'] }}" class="font-semibold hover:text-accent">{{ $c['email'] }}</a></li>
                    </ul>

                    @if(filled($c['whatsapp']))
                        <a href="https://wa.me/{{ $c['whatsapp'] }}" target="_blank" rel="noopener"
                           class="mt-5 inline-block rounded-lg bg-accent px-5 py-2.5 text-sm font-semibold text-white transition hover:brightness-110">
                            {{ __('contact.whatsapp') }}
                        </a>
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

                    <button type="submit"
                            class="rounded-lg bg-primary px-8 py-3 font-semibold text-white transition hover:bg-primary-dark">
                        {{ __('contact.submit') }}
                    </button>
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