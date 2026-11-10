@php
    $current  = app()->getLocale();
    $segments = request()->segments();

    $urlFor = function (string $target) use ($segments) {
        $segments[0] = $target;
        $qs = request()->getQueryString();
        return url(implode('/', $segments)) . ($qs ? '?' . $qs : '');
    };
@endphp

<div class="flex items-center gap-2 text-sm font-medium">
    <a href="{{ $urlFor('id') }}" class="{{ $current === 'id' ? 'font-bold underline' : 'opacity-70 hover:opacity-100' }}">ID</a>
    <span>|</span>
    <a href="{{ $urlFor('en') }}" class="{{ $current === 'en' ? 'font-bold underline' : 'opacity-70 hover:opacity-100' }}">EN</a>
</div>