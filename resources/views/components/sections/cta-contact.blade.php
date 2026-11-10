<section class="bg-sky/60 py-16">
    <div class="container mx-auto max-w-4xl px-6">
        <div class="rounded-3xl bg-white p-10 text-center shadow-xl md:p-14">
            <h2 class="text-3xl font-extrabold text-primary md:text-4xl">{{ __('home.cta_title') }}</h2>
            <p class="mx-auto mt-4 max-w-xl text-slate-600">{{ __('home.cta_text') }}</p>

            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact') }}"
                   class="rounded-lg bg-primary px-8 py-3 font-semibold text-white transition hover:bg-primary-dark">
                    {{ __('nav.contact') }}
                </a>
                <a href="{{ route('visit') }}"
                   class="rounded-lg border-2 border-primary px-8 py-3 font-semibold text-primary transition hover:bg-primary hover:text-white">
                    {{ __('nav.visit') }}
                </a>
            </div>
        </div>
    </div>
</section>