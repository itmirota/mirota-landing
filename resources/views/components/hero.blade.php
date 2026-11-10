<section class="relative min-h-screen flex items-center">

    <div class="absolute inset-0">
        <img src="{{ asset('images/building.jpg') }}" alt="PT Mirota KSM"
             class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/20"></div>

    <div class="relative container mx-auto px-6 pt-28 pb-16">
        <div class="max-w-2xl text-white">

            <span class="inline-block rounded-full bg-sky-200/90 px-4 py-1 text-xs font-bold uppercase tracking-wider text-primary-dark">
                {{ __('home.hero_badge') }}
            </span>

            <h1 class="mt-5 text-4xl md:text-6xl font-bold leading-tight">
                {{ __('home.hero_title') }}
            </h1>

            <p class="mt-5 text-lg text-gray-200">
                {{ __('home.hero_text') }}
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('produk.index') }}"
                   class="rounded-lg bg-sky-200 px-6 py-3 font-semibold text-primary-dark transition hover:brightness-95">
                    {{ __('home.cta_products') }}
                </a>

                <a href="{{ url(app()->getLocale().'/maklon') }}"
                   class="rounded-lg border border-white px-6 py-3 font-semibold transition hover:bg-white hover:text-primary-dark">
                    {{ __('home.cta_maklon') }}
                </a>
            </div>
        </div>
    </div>
</section>