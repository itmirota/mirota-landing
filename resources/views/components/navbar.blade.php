@php
    $l = app()->getLocale();

    // Halaman yang belum dibuat akan 404 dulu, kita isi bertahap.
    $menu = [
        ['label' => __('nav.home'), 'href' => route('home'), 'match' => $l],
        ['label' => __('nav.about'), 'match' => "$l/tentang-kami*", 'children' => [
            ['label' => __('nav.about_history'), 'href' => url("$l/tentang-kami/sejarah")],
            ['label' => __('nav.about_vision'),  'href' => url("$l/tentang-kami/visi-misi-budaya")],
            ['label' => __('nav.about_quality'), 'href' => url("$l/tentang-kami/kebijakan-mutu")],
            ['label' => __('nav.about_awards'),  'href' => url("$l/tentang-kami/penghargaan")],
        ]],
        ['label' => __('nav.products'), 'href' => route('produk.index'), 'match' => "$l/produk*"],
        ['label' => __('nav.maklon'),   'href' => url("$l/maklon"),            'match' => "$l/maklon*"],
        ['label' => __('nav.visit'),    'href' => url("$l/kunjungan-industri"), 'match' => "$l/kunjungan-industri*"],
        ['label' => __('nav.career'), 'match' => "$l/karir*", 'children' => [
            ['label' => __('nav.career_benefit'), 'href' => url("$l/karir/benefit")],
            ['label' => __('nav.career_team'),    'href' => url("$l/karir/tim")],
            ['label' => __('nav.career_jobs'),    'href' => url("$l/karir/lowongan")],
        ]],
        ['label' => __('nav.articles'), 'href' => url("$l/artikel"), 'match' => "$l/artikel*"],
        ['label' => __('nav.contact'),  'href' => url("$l/kontak"),  'match' => "$l/kontak*"],
    ];

    $linkBase = 'transition hover:text-accent';
@endphp

<nav class="fixed left-0 right-0 top-3 mx-auto w-[92%] max-w-6xl z-50 px-4 md:px-8 py-3 bg-white/85 backdrop-blur-md shadow-md rounded-md">
    <div class="flex items-center justify-between gap-4">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="shrink-0">
            <img src="{{ asset('images/mirota.png') }}" alt="PT Mirota KSM" class="h-10 w-auto">
        </a>

        {{-- Menu desktop --}}
        <ul class="hidden lg:flex items-center gap-6 text-sm xl:text-base font-bold text-primary">
            @foreach($menu as $item)
                @php $active = request()->is($item['match']); @endphp

                @if(isset($item['children']))
                    <li class="relative"
                        x-data="{ sub: false }"
                        @mouseenter="sub = true" @mouseleave="sub = false"
                        @keydown.escape="sub = false">
                        <button type="button" @click="sub = !sub"
                                class="flex items-center gap-1 {{ $linkBase }} {{ $active ? 'text-accent' : '' }}">
                            {{ $item['label'] }}
                            <svg class="size-4" viewBox="0 0 20 20" fill="currentColor"><path d="M5.5 7.5 10 12l4.5-4.5"/></svg>
                        </button>
                        <div x-show="sub" x-cloak x-transition class="absolute left-0 top-full pt-3 min-w-56">
                            <ul class="bg-white rounded-md shadow-lg py-2">
                                @foreach($item['children'] as $child)
                                    <li>
                                        <a href="{{ $child['href'] }}"
                                           class="block px-4 py-2 text-sm font-semibold hover:bg-gray-100 hover:text-accent">
                                            {{ $child['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @else
                    <li>
                        <a href="{{ $item['href'] }}" class="{{ $linkBase }} {{ $active ? 'text-accent' : '' }}">
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>

        {{-- Kanan: bahasa + hamburger --}}
        <div class="flex items-center gap-4">
            <x-lang-switcher />

            <button type="button" class="lg:hidden bg-primary p-2 rounded-lg" @click="open = !open" aria-label="Menu">
                <svg class="size-5" viewBox="0 0 24 24" fill="none">
                    <path d="M4 6H20M4 12H20M4 18H20" stroke="#F5EB29" stroke-width="3" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Menu mobile --}}
    <div x-show="open" x-cloak x-transition class="lg:hidden absolute top-full left-0 w-full mt-2">
        <ul class="bg-primary text-white rounded-md p-3 max-h-[70vh] overflow-y-auto space-y-1">
            @foreach($menu as $item)
                @if(isset($item['children']))
                    <li class="px-2 pt-2 font-bold">{{ $item['label'] }}</li>
                    @foreach($item['children'] as $child)
                        <li><a href="{{ $child['href'] }}" class="block py-1.5 pl-6 text-sm opacity-90">{{ $child['label'] }}</a></li>
                    @endforeach
                @else
                    <li><a href="{{ $item['href'] }}" class="block px-2 py-1.5 font-bold">{{ $item['label'] }}</a></li>
                @endif
            @endforeach
        </ul>
    </div>
</nav>