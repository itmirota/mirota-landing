@php
    $tabs = [
        'career.benefit' => __('nav.career_benefit'),
        'career.team'    => __('nav.career_team'),
        'career.jobs'    => __('nav.career_jobs'),
    ];
@endphp

<div class="border-b bg-white">
    <div class="container mx-auto flex gap-6 overflow-x-auto px-6 text-sm font-semibold">
        @foreach($tabs as $route => $label)
            @php $active = request()->routeIs($route) || ($route === 'career.jobs' && request()->routeIs('career.job')); @endphp
            <a href="{{ route($route) }}"
               class="whitespace-nowrap border-b-2 py-4 transition
                      {{ $active ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-primary' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
</div>