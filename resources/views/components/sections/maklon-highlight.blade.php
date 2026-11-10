<section class="relative overflow-hidden bg-linear-to-br from-primary-dark via-primary to-primary-light py-20 text-white">
    <div class="absolute -right-24 -top-24 h-80 w-80 rounded-full bg-white/10"></div>
    <div class="absolute -bottom-28 left-1/4 h-60 w-60 rounded-full bg-accent/25"></div>

    <div class="relative container mx-auto grid max-w-6xl items-center gap-12 px-6 lg:grid-cols-2">

        <div>
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-sky-200">{{ __('nav.maklon') }}</p>
            <h2 class="mt-2 text-3xl font-extrabold md:text-4xl">{{ __('home.maklon_title') }}</h2>
            <p class="mt-4 text-lg text-white/85">{{ __('home.maklon_text') }}</p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('maklon') }}"
                   class="rounded-lg bg-accent px-6 py-3 font-semibold text-white transition hover:brightness-110">
                    {{ __('home.maklon_button') }}
                </a>
                <a href="{{ route('contact', ['type' => 'maklon']) }}"
                   class="rounded-lg border border-white px-6 py-3 font-semibold transition hover:bg-white hover:text-primary-dark">
                    {{ __('home.maklon_contact') }}
                </a>
            </div>
        </div>

        <ul class="space-y-4">
            @foreach(trans('home.maklon_points') as $i => $point)
                <li class="flex items-start gap-4 rounded-2xl bg-white/10 p-5 backdrop-blur">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-accent text-lg font-extrabold">{{ $i + 1 }}</span>
                    <div>
                        <h3 class="font-bold">{{ $point['title'] }}</h3>
                        <p class="mt-1 text-sm text-white/80">{{ $point['text'] }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>