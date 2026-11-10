@php
    $photo = file_exists(public_path('images/history/gedung-lama.jpg'))
        ? 'images/history/gedung-lama.jpg'
        : 'images/building.jpg';
@endphp

<section class="bg-linear-to-b from-sky/60 to-white py-20">
    <div class="container mx-auto grid max-w-6xl items-center gap-12 px-6 lg:grid-cols-2">

        <div class="relative">
            <div class="absolute -bottom-4 -right-4 h-full w-full rounded-3xl bg-accent/20"></div>
            <img src="{{ asset($photo) }}" alt="PT Mirota KSM" loading="lazy"
                 class="relative aspect-[4/3] w-full rounded-3xl border-4 border-white object-cover shadow-xl">
        </div>

        <div>
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-accent">{{ __('home.about_label') }}</p>
            <h2 class="mt-2 text-3xl font-extrabold text-primary md:text-4xl">{{ __('home.about_title') }}</h2>
            <p class="mt-4 text-lg leading-relaxed text-slate-700">{{ __('home.about_text') }}</p>

            <div class="mt-8 grid grid-cols-3 gap-4">
                @foreach(trans('about.history.stats') as $stat)
                    <div class="rounded-2xl bg-white p-4 text-center shadow-md">
                        <p class="text-2xl font-extrabold text-accent md:text-3xl">{{ $stat['value'] }}</p>
                        <p class="mt-1 text-xs font-medium text-slate-500">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>

            <a href="{{ route('about.history') }}"
               class="mt-8 inline-block rounded-lg bg-primary px-6 py-3 font-semibold text-white transition hover:bg-primary-dark">
                {{ __('home.about_button') }}
            </a>
        </div>
    </div>
</section>