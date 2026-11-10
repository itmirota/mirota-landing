@php
    $tabs = [
        'about.history' => __('nav.about_history'),
        'about.vision'  => __('nav.about_vision'),
        'about.quality' => __('nav.about_quality'),
        'about.awards'  => __('nav.about_awards'),
    ];
@endphp

<div class="border-b bg-white">
    <div class="container mx-auto flex gap-6 overflow-x-auto px-6 text-sm font-semibold">
        @foreach($tabs as $route => $label)
            <a href="{{ route($route) }}"
               class="whitespace-nowrap border-b-2 py-4 transition
                      {{ request()->routeIs($route) ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-primary' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
</div>