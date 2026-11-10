<section class="py-20 bg-white">
    <div class="container mx-auto px-6">

        <div class="text-center max-w-3xl mx-auto mb-14">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                {{ __('home.why_title') }}
            </h2>
            <p class="mt-4 text-gray-600">
                {{ __('home.why_text') }}
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach(trans('home.features') as $feature)
                <div class="p-6 rounded-2xl border border-gray-100 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10 text-2xl">
                        {{ $feature['icon'] }}
                    </div>
                    <h3 class="mb-2 text-lg font-semibold text-gray-900">{{ $feature['title'] }}</h3>
                    <p class="text-sm text-gray-600">{{ $feature['text'] }}</p>
                </div>
            @endforeach
        </div>

    </div>
</section>