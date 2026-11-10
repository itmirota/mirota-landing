@php $l = app()->getLocale(); @endphp

<footer class="bg-primary-dark text-white">
    <div class="mx-auto grid max-w-6xl gap-10 px-6 py-14 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Brand + sosial media --}}
        <div>
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/mirota.png') }}"
                    alt="PT Mirota KSM"
                    class="h-10 w-auto rounded bg-white p-1">
            </a>

            <p class="mt-4 text-sm text-white/80">{{ __('footer.tagline') }}</p>

            <div class="mt-5 flex items-center gap-3">

                {{-- Instagram --}}
                @if(filled(config('company.social.instagram')))
                    <a href="{{ config('company.social.instagram') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Instagram PT Mirota KSM"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/10 transition hover:bg-accent hover:scale-110">

                        <svg class="h-5 w-5" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="5"/>
                            <circle cx="12" cy="12" r="4"/>
                            <circle cx="17.5" cy="6.5" r="1"
                                    fill="currentColor" stroke="none"/>
                        </svg>
                    </a>
                @endif

                {{-- TikTok --}}
                @if(filled(config('company.social.tiktok')))
                    <a href="{{ config('company.social.tiktok') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="TikTok PT Mirota KSM"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/10 transition hover:bg-accent hover:scale-110">

                        <svg class="h-5 w-5" viewBox="0 0 24 24"
                            fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.33V2h-3.35v13.67a2.9 2.9 0 0 1-2.9 2.9
                            2.9 2.9 0 1 1 2.9-2.9c0-.15-.01-.3-.02-.45V8.8
                            a6.3 6.3 0 1 0 3.37 5.57V9.6a8.16 8.16 0 0 0 4.77 1.53V7.78
                            a4.85 4.85 0 0 1-1-.09z"/>
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