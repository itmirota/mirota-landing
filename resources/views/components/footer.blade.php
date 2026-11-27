@php $l = app()->getLocale(); @endphp

<footer class="bg-primary-dark text-white">
    <div class="mx-auto grid max-w-6xl gap-10 px-6 py-14 sm:grid-cols-2 lg:grid-cols-4">

 

{{-- Brand + sosial media --}}
<div>
    <a href="{{ route('home') }}">
        <img src="{{ asset('images/mirota.png') }}"
             alt="PT Mirota KSM"
             class="h-10 w-auto object-contain">
    </a>

    <p class="mt-4 text-sm text-white/80">
        {{ __('footer.tagline') }}
    </p>

    <div class="mt-5 flex flex-wrap items-center gap-3">

        {{-- Instagram --}}
        @if(filled(config('company.social.instagram')))
            <a href="{{ config('company.social.instagram') }}"
               target="_blank"
               rel="noopener noreferrer"
               aria-label="Instagram PT Mirota KSM"
               class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white transition hover:scale-110">

                <svg class="h-6 w-6" viewBox="0 0 24 24"
                     fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="instagram-gradient"
                            x1="3" y1="21" x2="21" y2="3"
                            gradientUnits="userSpaceOnUse">
                            <stop stop-color="#FEDA75"/>
                            <stop offset="0.35" stop-color="#FA7E1E"/>
                            <stop offset="0.65" stop-color="#D62976"/>
                            <stop offset="1" stop-color="#4F5BD5"/>
                        </linearGradient>
                    </defs>
                    <rect x="3" y="3" width="18" height="18" rx="5"
                          stroke="url(#instagram-gradient)" stroke-width="2"/>
                    <circle cx="12" cy="12" r="4"
                            stroke="url(#instagram-gradient)" stroke-width="2"/>
                    <circle cx="17.5" cy="6.5" r="1.2"
                            fill="#D62976"/>
                </svg>
            </a>
        @endif

        {{-- TikTok --}}
        @if(filled(config('company.social.tiktok')))
            <a href="{{ config('company.social.tiktok') }}"
               target="_blank"
               rel="noopener noreferrer"
               aria-label="TikTok PT Mirota KSM"
               class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white transition hover:scale-110">

                <svg class="h-6 w-6" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill="#25F4EE"
                        d="M15.5 3h-3.2v12.1a2.8 2.8 0 1 1-2.8-2.8c.3 0 .6 0 .9.1V9.1a6 6 0 1 0 5.1 5.9V8.8a8 8 0 0 0 4.5 1.4V7a4.8 4.8 0 0 1-4.5-4z"
                        transform="translate(-0.8 0.3)"/>
                    <path fill="#FE2C55"
                        d="M15.5 3h-3.2v12.1a2.8 2.8 0 1 1-2.8-2.8c.3 0 .6 0 .9.1V9.1a6 6 0 1 0 5.1 5.9V8.8a8 8 0 0 0 4.5 1.4V7a4.8 4.8 0 0 1-4.5-4z"
                        transform="translate(0.5 0.2)"/>
                    <path fill="#111111"
                        d="M15.5 3h-3.2v12.1a2.8 2.8 0 1 1-2.8-2.8c.3 0 .6 0 .9.1V9.1a6 6 0 1 0 5.1 5.9V8.8a8 8 0 0 0 4.5 1.4V7a4.8 4.8 0 0 1-4.5-4z"/>
                </svg>
            </a>
        @endif

        {{-- Shopee --}}
        @if(filled(config('company.social.shopee')))
            <a href="{{ config('company.social.shopee') }}"
               target="_blank"
               rel="noopener noreferrer"
               aria-label="Shopee PT Mirota KSM"
               class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white transition hover:scale-110">

                <svg class="h-6 w-6" viewBox="0 0 24 24"
                     fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 8h14l1.3 13H3.7L5 8Z"
                          stroke="#EE4D2D" stroke-width="1.8"
                          stroke-linejoin="round"/>
                    <path d="M9 8V6a3 3 0 0 1 6 0v2"
                          stroke="#EE4D2D" stroke-width="1.8"
                          stroke-linecap="round"/>
                    <text x="12" y="17" text-anchor="middle"
                          fill="#EE4D2D" font-size="10"
                          font-weight="bold">S</text>
                </svg>
            </a>
        @endif

        {{-- Tokopedia --}}
        @if(filled(config('company.social.tokopedia')))
            <a href="{{ config('company.social.tokopedia') }}"
               target="_blank"
               rel="noopener noreferrer"
               aria-label="Tokopedia PT Mirota KSM"
               class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white transition hover:scale-110">

                <svg class="h-6 w-6" viewBox="0 0 24 24"
                     fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 8.5 6.5 5h11L19 8.5V20H5V8.5Z"
                          fill="#03AC0E"/>
                    <path d="M9 5V4a3 3 0 0 1 6 0v1"
                          stroke="#03AC0E" stroke-width="1.6"
                          stroke-linecap="round"/>
                    <circle cx="9.5" cy="11.5" r="2"
                            fill="white"/>
                    <circle cx="14.5" cy="11.5" r="2"
                            fill="white"/>
                    <circle cx="10" cy="11.5" r=".7"
                            fill="#03AC0E"/>
                    <circle cx="14" cy="11.5" r=".7"
                            fill="#03AC0E"/>
                    <path d="M10 16q2 1.8 4 0"
                          stroke="white" stroke-width="1.3"
                          stroke-linecap="round"/>
                </svg>
            </a>
        @endif

    </div>
</div>


        {{-- Perusahaan --}}
        <div>
            <h3 class="mb-4 font-bold text-sky-200">{{ __('footer.company') }}</h3>
            <ul class="space-y-2.5 text-sm text-white/85">
                <li><a href="{{ route('about.history') }}" class="transition hover:text-white hover:underline">{{ __('nav.about') }}</a></li>
                <li><a href="{{ route('about.vision') }}" class="transition hover:text-white hover:underline">{{ __('nav.about_vision') }}</a></li>
                <li><a href="{{ route('about.quality') }}" class="transition hover:text-white hover:underline">{{ __('nav.about_quality') }}</a></li>
                <li><a href="{{ route('career.jobs') }}" class="transition hover:text-white hover:underline">{{ __('nav.career') }}</a></li>
                <li><a href="{{ route('article.index') }}" class="transition hover:text-white hover:underline">{{ __('nav.articles') }}</a></li>
            </ul>
        </div>

        {{-- Layanan --}}
        <div>
            <h3 class="mb-4 font-bold text-sky-200">{{ __('footer.services') }}</h3>
            <ul class="space-y-2.5 text-sm text-white/85">
                <li><a href="{{ route('produk.index') }}" class="transition hover:text-white hover:underline">{{ __('nav.products') }}</a></li>
                <li><a href="{{ route('maklon') }}" class="transition hover:text-white hover:underline">{{ __('nav.maklon') }}</a></li>
                <li><a href="{{ route('visit') }}" class="transition hover:text-white hover:underline">{{ __('nav.visit') }}</a></li>
                <li><a href="{{ route('contact') }}" class="transition hover:text-white hover:underline">{{ __('nav.contact') }}</a></li>
            </ul>
        </div>

        {{-- Kontak --}}
        <div>
            <h3 class="mb-4 font-bold text-sky-200">{{ __('nav.contact') }}</h3>
            <ul class="space-y-2.5 text-sm text-white/85">
                <li>{{ config('company.address') }}</li>
                <li>📞 {{ config('company.customer_care.phone') }}</li>
                <li>✉️ {{ config('company.customer_care.email') }}</li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/15">
        <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-2 px-6 py-5 text-xs text-white/70 sm:flex-row">
            <p>© {{ date('Y') }} PT Mirota KSM. {{ __('footer.rights') }}</p>
            <a href="{{ route('privacy') }}" class="hover:text-white hover:underline">{{ __('footer.privacy') }}</a>
        </div>
    </div>
</footer>