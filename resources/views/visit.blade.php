@extends('layouts.app')
@section('title', __('visit.title').' | PT Mirota KSM')

@php
    $input = 'mt-1 w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20';
@endphp

@section('content')
<x-page-header :title="__('visit.title')" :subtitle="__('visit.subtitle')" :label="__('nav.visit')" />

{{-- Pengantar + yang didapat --}}
<section class="bg-linear-to-b from-sky/70 to-white py-20">
    <div class="container mx-auto max-w-6xl px-6">
        

        <div class="mx-auto max-w-3xl text-center">
            <h2 class="text-3xl font-extrabold text-primary md:text-4xl">{{ __('visit.intro_title') }}</h2>
            <p class="mt-4 text-lg text-slate-700">{{ __('visit.intro_text') }}</p>
        </div>

        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach(trans('visit.benefits') as $b)
                <div class="rounded-2xl bg-white p-6 shadow-md transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10 text-2xl">{{ $b['icon'] }}</div>
                    <h3 class="mt-4 text-lg font-bold text-primary-dark">{{ $b['title'] }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $b['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Galeri (carousel) --}}
@if($photos->isNotEmpty())
@php
    $slides = $photos->map(fn ($p) => [
        'src'     => asset('storage/'.$p->image),
        'caption' => $p->localized('caption'),
    ])->values();
@endphp

<section class="overflow-hidden bg-white py-20">
    <div class="container mx-auto max-w-6xl px-6">
        <h2 class="text-center text-3xl font-extrabold text-primary md:text-4xl">{{ __('visit.gallery_title') }}</h2>
        <div class="mx-auto mt-3 h-1 w-16 rounded-full bg-accent"></div>

        <div x-data="visitGallery(@js($slides))"
             @resize.window.debounce.200ms="measure()"
             @keydown.escape.window="close()"
             @keydown.arrow-right.window="lightbox !== null && lbNext()"
             @keydown.arrow-left.window="lightbox !== null && lbPrev()"
             @mouseenter="stop()" @mouseleave="start()"
             @touchstart.passive="tx = $event.touches[0].clientX; stop()"
             @touchend="swipe($event); start()"
             class="relative mt-12">

            {{-- Viewport + track --}}
            <div x-ref="viewport" class="-mx-2 overflow-hidden py-4">
                <div class="flex"
                     :style="`transform: translateX(-${x}px); transition: ${animate ? 'transform ' + duration + 'ms cubic-bezier(.22,.61,.36,1)' : 'none'}`">

                    <template x-for="item in items" :key="item.uid">
                        <div class="shrink-0 px-2" :style="`width: ${100 / perView}%`">
                            <button type="button" @click="open(item.orig)"
                                    class="group relative block aspect-[4/3] w-full overflow-hidden rounded-3xl shadow-lg ring-1 ring-black/5">
                                <img :src="item.src" :alt="item.caption || ''" draggable="false"
                                     class="h-full w-full object-cover transition duration-500 group-hover:scale-110">

                                <span class="pointer-events-none absolute inset-0 bg-linear-to-t from-black/70 via-transparent to-transparent"></span>

                                <span x-show="item.caption" x-text="item.caption"
                                      class="absolute inset-x-0 bottom-0 p-5 text-left text-sm font-semibold text-white"></span>

                                <span class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-lg text-primary opacity-0 shadow transition group-hover:opacity-100">⤢</span>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Panah di sisi foto (desktop) --}}
            <button type="button" @click="prev()" aria-label="Previous"
                    class="absolute left-2 top-1/2 z-10 hidden h-14 w-14 -translate-y-1/2 items-center justify-center rounded-full bg-white/95 text-primary shadow-xl ring-1 ring-black/5 backdrop-blur transition hover:scale-110 hover:bg-primary hover:text-white md:flex">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <button type="button" @click="next()" aria-label="Next"
                    class="absolute right-2 top-1/2 z-10 hidden h-14 w-14 -translate-y-1/2 items-center justify-center rounded-full bg-white/95 text-primary shadow-xl ring-1 ring-black/5 backdrop-blur transition hover:scale-110 hover:bg-primary hover:text-white md:flex">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>
            </button>

            {{-- Bar navigasi bawah (semua layar) --}}
            <div class="mt-6 flex items-center justify-center gap-4">
                <button type="button" @click="prev()" aria-label="Previous"
                        class="flex h-11 w-11 items-center justify-center rounded-full border-2 border-primary/20 bg-white text-primary transition hover:bg-primary hover:text-white">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                </button>

                <div class="flex items-center gap-2">
                    <template x-for="(s, i) in slides" :key="i">
                        <button type="button" @click="go(i)" :aria-label="'Slide ' + (i + 1)"
                                :class="cur === i ? 'w-8 bg-accent' : 'w-2.5 bg-primary/30 hover:bg-primary/60'"
                                class="h-2.5 rounded-full transition-all duration-300"></button>
                    </template>
                </div>

                <button type="button" @click="next()" aria-label="Next"
                        class="flex h-11 w-11 items-center justify-center rounded-full border-2 border-primary/20 bg-white text-primary transition hover:bg-primary hover:text-white">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>
                </button>
            </div>

            <p class="mt-3 text-center text-xs font-semibold tracking-widest text-slate-400"
               x-text="String(cur + 1).padStart(2, '0') + ' / ' + String(slides.length).padStart(2, '0')"></p>

            {{-- Lightbox --}}
            <div x-show="lightbox !== null" x-cloak x-transition.opacity
                 class="fixed inset-0 z-[60] flex items-center justify-center bg-black/90 p-4"
                 @click.self="close()">

                <button type="button" @click="close()" aria-label="Close"
                        class="absolute right-5 top-5 flex h-11 w-11 items-center justify-center rounded-full bg-white/15 text-2xl text-white transition hover:bg-white/30">✕</button>

                <button type="button" @click="lbPrev()" aria-label="Previous"
                        class="absolute left-4 flex h-12 w-12 items-center justify-center rounded-full bg-white/15 text-white transition hover:bg-white/30">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                </button>

                <figure class="max-w-5xl text-center">
                    <img :src="lightbox !== null ? slides[lightbox].src : ''" alt=""
                         class="mx-auto max-h-[80vh] max-w-full rounded-2xl shadow-2xl">
                    <figcaption class="mt-4 text-sm text-white/90">
                        <span x-text="lightbox !== null ? slides[lightbox].caption : ''"></span>
                        <span class="ml-2 text-white/50" x-text="lightbox !== null ? (lightbox + 1) + ' / ' + slides.length : ''"></span>
                    </figcaption>
                </figure>

                <button type="button" @click="lbNext()" aria-label="Next"
                        class="absolute right-4 flex h-12 w-12 items-center justify-center rounded-full bg-white/15 text-white transition hover:bg-white/30">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>
                </button>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Video --}}
@if($videos->isNotEmpty())
<section class="bg-sky/50 py-20">
    <div class="container mx-auto max-w-6xl px-6">
        <h2 class="text-center text-3xl font-extrabold text-primary md:text-4xl">{{ __('visit.video_title') }}</h2>

        <div class="mt-10 grid gap-8 {{ $videos->count() > 1 ? 'md:grid-cols-2' : 'mx-auto max-w-3xl' }}">
            @foreach($videos as $video)
                <div>
                    <div class="aspect-video overflow-hidden rounded-2xl border-4 border-white shadow-xl">
                        <iframe class="h-full w-full" loading="lazy"
                                src="https://www.youtube-nocookie.com/embed/{{ $video->youtube_id }}"
                                title="{{ $video->localized('title') }}"
                                allow="accelerometer; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <p class="mt-3 text-center font-semibold text-slate-700">{{ $video->localized('title') }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Instansi yang pernah berkunjung --}}
@if($institutions->isNotEmpty())
<section class="bg-white py-16">
    <div class="container mx-auto max-w-6xl px-6">
        <h2 class="text-center text-2xl font-extrabold text-primary md:text-3xl">{{ __('visit.institutions_title') }}</h2>

        <div class="mt-10 grid grid-cols-2 gap-5 md:grid-cols-4 lg:grid-cols-6">
            @foreach($institutions as $inst)
                <div class="flex h-28 items-center justify-center rounded-2xl border border-slate-100 bg-white p-4 text-center shadow-sm">
                    @if($inst->logo)
                        <img src="{{ asset('storage/'.$inst->logo) }}" alt="{{ $inst->name }}" class="max-h-full max-w-full object-contain">
                    @else
                        <span class="text-xs font-bold text-primary">{{ $inst->name }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Pengajuan --}}
@php
    $box   = 'rounded-lg border border-slate-200 bg-white px-5 shadow-sm transition focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/20';
    $field = 'w-full bg-transparent py-4 text-slate-700 outline-none placeholder:text-slate-500';
    $inner = 'w-full bg-transparent pb-2.5 pt-0.5 text-slate-700 outline-none';
    $label = 'block pt-2 text-xs text-slate-500';
    $formMsg = [
    'big'      => __('visit.file_too_big'),
    'type'     => __('visit.file_bad_type'),
    'ktpHint'  => __('visit.ktp_hint'),
    'npwpHint' => __('visit.npwp_hint'),
    'labels'   => ['ktp_photo' => __('visit.ktp_photo'), 'letter' => __('visit.letter')],
];
@endphp

<section id="form" class="scroll-mt-24 bg-linear-to-b from-white to-sky/60 py-16"
         x-data="{
             terms: false,
             sending: false,
             source: @js(old('source', '')),
             ktp: @js(old('ktp_number', '')),
             npwp: @js(old('npwp', '')),
             fileErr: { ktp_photo: '', letter: '' },
             msg: @js($formMsg),
             get npwpDigits() { return this.npwp.replace(/\D/g, '').length },
             checkFile(event, key, maxMb, exts) {
                 const input = event.target;
                 const file = input.files[0];
                 this.fileErr[key] = '';
                 if (!file) return;
                 const label = this.msg.labels[key];
                 const ext = file.name.split('.').pop().toLowerCase();
                 if (!exts.includes(ext)) {
                     this.fileErr[key] = this.msg.type.replace(':name', label).replace(':types', exts.join(', ').toUpperCase());
                     input.value = '';
                 } else if (file.size > maxMb * 1048576) {
                     this.fileErr[key] = this.msg.big.replace(':name', label).replace(':size', (file.size / 1048576).toFixed(1)).replace(':max', maxMb);
                     input.value = '';
                 }
             },
             onSubmit(event) {
                 if (this.fileErr.ktp_photo || this.fileErr.letter) {
                     event.preventDefault();
                     return;
                 }
                 this.sending = true;
             }
         }"
         x-effect="document.body.classList.toggle('overflow-hidden', terms)"
         @keydown.escape.window="terms = false">

    <div class="container mx-auto max-w-5xl px-6">

        <button type="button" @click="terms = true"
                class="rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-dark">
            {{ __('visit.terms_button') }}
        </button>

        <h2 class="mt-6 text-3xl font-extrabold text-primary">{{ __('visit.form_title') }}</h2>

        @if(session('success'))
            <div class="mt-5 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div x-init="$nextTick(() => $el.scrollIntoView({ behavior: 'smooth', block: 'start' }))"
                class="mt-5 scroll-mt-28 rounded-lg border border-red-300 bg-red-50 p-4 text-sm text-red-800" role="alert">
                <p class="font-bold">{{ __('visit.error_summary') }}</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <p class="mt-3 text-xs text-red-700">{{ __('visit.error_files_hint') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('visit.store') }}" enctype="multipart/form-data"
              @submit="onSubmit($event)" class="mt-6">
            @csrf

            <div class="hidden" aria-hidden="true">
                <input type="text" name="website" tabindex="-1" autocomplete="off">
            </div>

            <div class="grid gap-4 md:grid-cols-2">

                {{-- Kolom kiri --}}
                <div class="space-y-4">
                    <div>
                        <div class="{{ $box }}">
                            <input name="institution" value="{{ old('institution') }}" required
                                   placeholder="{{ __('visit.institution') }}" aria-label="{{ __('visit.institution') }}" class="{{ $field }}">
                        </div>
                        <x-form-error name="$1" />
                    </div>

                    <div>
                        <div class="{{ $box }}">
                            <input name="contact_name" value="{{ old('contact_name') }}" required
                                   placeholder="{{ __('visit.contact_name') }}" aria-label="{{ __('visit.contact_name') }}" class="{{ $field }}">
                        </div>
                       <x-form-error name="$1" />
                    </div>

                    <div>
                        <div class="{{ $box }}">
                            <input name="npwp" x-model="npwp" @input="npwp = npwp.replace(/[^0-9.\-\s]/g, '').slice(0, 24)"
                                inputmode="numeric"
                                placeholder="{{ __('visit.npwp') }}" aria-label="{{ __('visit.npwp') }}" class="{{ $field }}">
                        </div>
                        <p class="mt-1 text-xs"
                        :class="npwpDigits === 0 ? 'text-slate-500' : ([15, 16].includes(npwpDigits) ? 'text-green-600' : 'text-amber-600')"
                        x-text="msg.npwpHint.replace(':n', npwpDigits)"></p>
                        <x-form-error name="npwp" />
                    </div>

                    <div>
                        <div class="{{ $box }}">
                            <input name="ktp_number" x-model="ktp" @input="ktp = ktp.replace(/\D/g, '').slice(0, 16)"
                                inputmode="numeric" maxlength="16"
                                placeholder="{{ __('visit.ktp_number') }}" aria-label="{{ __('visit.ktp_number') }}" class="{{ $field }}">
                        </div>
                        <p class="mt-1 text-xs"
                        :class="ktp.length === 16 ? 'text-green-600' : (ktp.length ? 'text-amber-600' : 'text-slate-500')"
                        x-text="msg.ktpHint.replace(':n', ktp.length)"></p>
                        <p class="mt-0.5 text-xs text-slate-500">{{ __('visit.id_hint') }}</p>
                        <x-form-error name="ktp_number" />
                    </div>

                    <div>
                        <div class="{{ $box }}">
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   placeholder="Email" aria-label="Email" class="{{ $field }}">
                        </div>
                        <x-form-error name="$1" />
                    </div>

                    <div>
                        <div class="{{ $box }}">
                            <input name="phone" value="{{ old('phone') }}" required inputmode="tel"
                                   placeholder="{{ __('visit.phone') }}" aria-label="{{ __('visit.phone') }}" class="{{ $field }}">
                        </div>
                        
                    </div>

                    <div>
                        <div class="{{ $box }}">
                            <label for="source" class="{{ $label }}">{{ __('visit.source_label') }}</label>
                            <select id="source" name="source" x-model="source" required class="{{ $inner }}">
                                <option value="">{{ __('visit.source_placeholder') }}</option>
                                @foreach(trans('visit.sources') as $key => $text)
                                    <option value="{{ $key }}">{{ $text }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-form-error name="$1" />
                    </div>

                    {{-- Muncul hanya jika memilih "Tim Mirota" --}}
                    <div x-show="source === 'mirota_team'" x-cloak x-transition>
                        <div class="{{ $box }}">
                            <input name="mirota_team_name" value="{{ old('mirota_team_name') }}"
                                   :required="source === 'mirota_team'"
                                   placeholder="{{ __('visit.mirota_team_name') }}" aria-label="{{ __('visit.mirota_team_name') }}" class="{{ $field }}">
                        </div>
                        <x-form-error name="$1" />
                    </div>
                </div>

                {{-- Kolom kanan --}}
                <div class="space-y-4">
                    <div>
                        <div class="{{ $box }}">
                            <label for="province" class="{{ $label }}">{{ __('visit.province_label') }}</label>
                            <select id="province" name="province" required class="{{ $inner }}">
                                <option value="">{{ __('visit.province_placeholder') }}</option>
                                @foreach(config('provinces') as $province)
                                    <option value="{{ $province }}" @selected(old('province') === $province)>{{ $province }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-form-error name="$1" />
                    </div>

                    <div>
                        <div class="{{ $box }}">
                            <textarea name="address" rows="4" required
                                      placeholder="{{ __('visit.address') }}" aria-label="{{ __('visit.address') }}"
                                      class="{{ $field }} resize-y">{{ old('address') }}</textarea>
                        </div>
                        <x-form-error name="$1" />
                    </div>

                    <div>
                        <div class="{{ $box }}">
                            <label for="preferred_date" class="{{ $label }}">{{ __('visit.visit_at') }}</label>
                            <input id="preferred_date" type="datetime-local" name="preferred_date" step="900"
                                   min="{{ now()->addDay()->format('Y-m-d\T00:00') }}"
                                   value="{{ old('preferred_date') }}" required class="{{ $inner }}">
                        </div>
                        <p class="mt-1 text-xs text-slate-500">{{ __('visit.visit_at_hint') }}</p>
                        <x-form-error name="$1" />
                    </div>

                    <div>
                        <div class="{{ $box }}">
                            <input name="department" value="{{ old('department') }}"
                                   placeholder="{{ __('visit.department') }}" aria-label="{{ __('visit.department') }}" class="{{ $field }}">
                        </div>
                       <x-form-error name="$1" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="{{ $box }}">
                                <input type="number" name="visitors" min="1" max="500" value="{{ old('visitors') }}" required
                                       placeholder="{{ __('visit.visitors') }}" aria-label="{{ __('visit.visitors') }}" class="{{ $field }}">
                            </div>
                           <x-form-error name="$1" />
                        </div>
                        <div>
                            <div class="{{ $box }}">
                                <input type="number" name="companions" min="0" max="100" value="{{ old('companions') }}"
                                    placeholder="{{ __('visit.companions') }}" aria-label="{{ __('visit.companions') }}" class="{{ $field }}">
                            </div>
                            <x-form-error name="$1" />
                        </div>
                    </div>

                    <div>
                        <div class="{{ $box }}" :class="fileErr.ktp_photo && 'border-red-400 ring-2 ring-red-100'">
                            <label for="ktp_photo" class="{{ $label }}">{{ __('visit.ktp_photo') }}</label>
                            <input id="ktp_photo" type="file" name="ktp_photo" accept=".jpg,.jpeg,.png"
                                @change="checkFile($event, 'ktp_photo', 2, ['jpg', 'jpeg', 'png'])"
                                class="{{ $inner }} text-sm file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-1.5 file:text-slate-700">
                        </div>
                        <p class="mt-1 text-xs text-slate-500">{{ __('visit.file_hint_ktp') }}</p>
                        <p x-show="fileErr.ktp_photo" x-cloak x-text="fileErr.ktp_photo" role="alert"
                        class="mt-1.5 rounded-md bg-red-50 px-3 py-2 text-sm font-medium text-red-700"></p>
                        <x-form-error name="ktp_photo" />
                    </div>

                <div>
                    <div class="{{ $box }}" :class="fileErr.letter && 'border-red-400 ring-2 ring-red-100'">
                        <label for="letter" class="{{ $label }}">{{ __('visit.letter') }}</label>
                        <input id="letter" type="file" name="letter" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required
                            @change="checkFile($event, 'letter', 3, ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'])"
                            class="{{ $inner }} text-sm file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-1.5 file:text-slate-700">
                    </div>
                    <p class="mt-1 text-xs text-slate-500">{{ __('visit.file_hint_letter') }}</p>
                    <p x-show="fileErr.letter" x-cloak x-text="fileErr.letter" role="alert"
                    class="mt-1.5 rounded-md bg-red-50 px-3 py-2 text-sm font-medium text-red-700"></p>
                    <x-form-error name="letter" />
                </div>
                
                </div>
            </div>

            {{-- Persetujuan + kirim --}}
            <div class="mt-6">
                <label class="flex items-start gap-3 text-sm text-slate-700">
                    <input type="checkbox" name="agree" value="1" required @checked(old('agree'))
                           class="mt-0.5 h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary">
                    <span>
                        {{ __('visit.agree') }}
                        <button type="button" @click="terms = true" class="font-semibold text-primary underline">{{ __('visit.terms_button') }}</button>.
                    </span>
                </label>
                <x-form-error name="$1" />

                <p class="mt-3 text-xs text-slate-500">
                    {{ __('contact.privacy_note') }}
                    <a href="{{ route('privacy') }}" class="font-semibold text-primary underline">{{ __('footer.privacy') }}</a>.
                </p>

                <button type="submit" :disabled="sending"
                        class="mt-5 rounded-lg bg-primary px-8 py-3 font-semibold text-white transition hover:bg-primary-dark disabled:cursor-not-allowed disabled:opacity-60">
                    <span x-show="!sending">{{ __('visit.submit') }}</span>
                    <span x-show="sending" x-cloak>{{ __('visit.sending') }}</span>
                </button>
            </div>
        </form>
    </div>

    {{-- Jendela Ketentuan Umum --}}
    <div x-show="terms" x-cloak x-transition.opacity
         class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 p-4"
         @click.self="terms = false" role="dialog" aria-modal="true" aria-labelledby="terms-title">

        <div class="flex max-h-[88vh] w-full max-w-3xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b px-6 py-4">
                <h3 id="terms-title" class="text-lg font-bold text-primary">{{ __('visit.terms_title') }}</h3>
                <button type="button" @click="terms = false" aria-label="Close"
                        class="flex h-9 w-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
                </button>
            </div>

            <div class="overflow-y-auto px-6 py-5 text-sm leading-relaxed text-slate-700">
                <ol class="list-decimal space-y-3 pl-5">
                    @foreach(trans('visit.terms') as $term)
                        <li class="pl-1">{{ $term }}</li>
                    @endforeach
                </ol>

                <p class="mt-6 rounded-lg bg-sky/60 p-4 font-semibold text-primary-dark">{{ __('visit.terms_note') }}</p>

                <p class="mt-5 font-bold text-accent">
                    {{ __('visit.terms_pic') }}: {{ __('visit.terms_pic_number') }}
                </p>
            </div>

            <div class="border-t px-6 py-4 text-right">
                <button type="button" @click="terms = false"
                        class="rounded-lg bg-primary px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-dark">
                    {{ __('visit.terms_close') }}
                </button>
            </div>
        </div>
    </div>
</section>
@endsection