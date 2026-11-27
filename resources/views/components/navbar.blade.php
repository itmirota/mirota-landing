@php
    $l = app()->getLocale();

    // Navbar transparan hanya di beranda (di atas banner).
    $overHero = request()->routeIs('home');

    // true = logo Mirota juga tampil di atas banner (default: muncul setelah di-scroll).
    $showLogoOverHero = false;

    $menu = [
        ['label' => __('nav.home'), 'href' => route('home'), 'match' => $l],
        ['label' => __('nav.about'), 'match' => "$l/tentang-kami*", 'children' => [
            ['label' => __('nav.about_history'), 'href' => url("$l/tentang-kami/sejarah")],
            ['label' => __('nav.about_vision'),  'href' => url("$l/tentang-kami/visi-misi-budaya")],
            ['label' => __('nav.about_quality'), 'href' => url("$l/tentang-kami/kebijakan-mutu")],
            ['label' => __('nav.about_awards'),  'href' => url("$l/tentang-kami/penghargaan")],
        ]],
        ['label' => __('nav.products'), 'href' => route('produk.index'), 'match' => "$l/produk*"],
        ['label' => __('nav.maklon'),   'href' => url("$l/maklon"),             'match' => "$l/maklon*"],
        ['label' => __('nav.visit'),    'href' => url("$l/kunjungan-industri"), 'match' => "$l/kunjungan-industri*"],
        ['label' => __('nav.career'), 'match' => "$l/karir*", 'children' => [
            ['label' => __('nav.career_benefit'), 'href' => url("$l/karir/benefit")],
            ['label' => __('nav.career_team'),    'href' => url("$l/karir/tim")],
            ['label' => __('nav.career_jobs'),    'href' => url("$l/karir/lowongan")],
        ]],
        ['label' => __('nav.articles'), 'href' => url("$l/artikel"), 'match' => "$l/artikel*"],
        ['label' => __('nav.contact'),  'href' => url("$l/kontak"),  'match' => "$l/kontak*"],
    ];

    $linkCls   = 'relative whitespace-nowrap py-1 text-sm font-semibold transition-colors hover:text-accent focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-accent';
    $activeCls = 'after:absolute after:inset-x-0 after:-bottom-1 after:h-0.5 after:rounded-full after:bg-accent group-data-[solid=true]/nav:text-accent';
@endphp

<header class="group/nav fixed inset-x-0 top-0 z-50"
        data-solid="{{ $overHero ? 'false' : 'true' }}"
        x-data="{
            scrolled: window.scrollY > 40,
            menu: false,
            overHero: @js($overHero),
            get solid() { return this.scrolled || this.menu || !this.overHero }
        }"
        :data-solid="solid ? 'true' : 'false'"
        @scroll.window.passive="scrolled = window.scrollY > 40"
        @keydown.escape.window="menu = false">

    {{-- Bayangan tipis di atas banner supaya menu putih tetap terbaca --}}
    @if($overHero)
        <div class="pointer-events-none absolute inset-x-0 top-0 h-28 bg-linear-to-b from-black/35 to-transparent transition-opacity duration-300 group-data-[solid=true]/nav:opacity-0"></div>
    @endif

    <div class="relative mx-auto flex w-full max-w-7xl items-center justify-between gap-4 px-6 py-4 text-white [text-shadow:0_1px_6px_rgb(0_0_0/0.45)] transition-all duration-300 ease-out
                group-data-[solid=true]/nav:mt-3 group-data-[solid=true]/nav:w-[94%] group-data-[solid=true]/nav:rounded-xl group-data-[solid=true]/nav:bg-white/90 group-data-[solid=true]/nav:px-5 group-data-[solid=true]/nav:py-2 group-data-[solid=true]/nav:text-primary group-data-[solid=true]/nav:shadow-lg group-data-[solid=true]/nav:ring-1 group-data-[solid=true]/nav:ring-black/5 group-data-[solid=true]/nav:backdrop-blur-md group-data-[solid=true]/nav:[text-shadow:none]">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="shrink-0 transition-opacity duration-300 {{ $overHero && ! $showLogoOverHero ? 'pointer-events-none opacity-0 group-data-[solid=true]/nav:pointer-events-auto group-data-[solid=true]/nav:opacity-100' : '' }}">
            <img src="{{ asset('images/mirota.png') }}" alt="PT Mirota KSM"
                 class="h-12 w-auto drop-shadow-[0_2px_6px_rgb(0_0_0/0.35)] transition-all duration-300 group-data-[solid=true]/nav:h-9 group-data-[solid=true]/nav:drop-shadow-none">
        </a>

        {{-- Menu desktop --}}
        <ul class="hidden items-center gap-6 xl:flex">
            @foreach($menu as $item)
                @php $active = request()->is($item['match']); @endphp

                @if(isset($item['children']))
                    <li class="relative" x-data="{ sub: false }"
                        @mouseenter="sub = true" @mouseleave="sub = false" @keydown.escape="sub = false">
                        <button type="button" @click="sub = !sub" :aria-expanded="sub"
                                class="{{ $linkCls }} inline-flex items-center gap-1 {{ $active ? $activeCls : '' }}">
                            {{ $item['label'] }}
                            <svg class="h-3.5 w-3.5 transition-transform" :class="sub && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                        </button>

                        <div x-show="sub" x-cloak x-transition.opacity.duration.150ms
                             class="absolute left-0 top-full min-w-56 pt-3 [text-shadow:none]">
                            <ul class="overflow-hidden rounded-lg bg-white py-2 text-primary shadow-xl ring-1 ring-black/5">
                                @foreach($item['children'] as $child)
                                    <li>
                                        <a href="{{ $child['href'] }}"
                                           class="block px-4 py-2 text-sm font-semibold transition hover:bg-sky/60 hover:text-accent">
                                            {{ $child['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @else
                    <li>
                        <a href="{{ $item['href'] }}" class="{{ $linkCls }} {{ $active ? $activeCls : '' }}">{{ $item['label'] }}</a>
                    </li>
                @endif
            @endforeach
        </ul>

        {{-- Kanan: bahasa + hamburger --}}
        <div class="flex shrink-0 items-center gap-3">
            <x-lang-switcher />

            <button type="button" @click="menu = !menu" :aria-expanded="menu" aria-label="Menu"
                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/15 text-white ring-1 ring-white/40 backdrop-blur transition xl:hidden group-data-[solid=true]/nav:bg-primary group-data-[solid=true]/nav:ring-0">
                <svg x-show="!menu" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="menu" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
        </div>

        {{-- Menu mobile --}}
        <div x-show="menu" x-cloak x-transition
             class="absolute inset-x-0 top-full mt-2 max-h-[75vh] overflow-y-auto rounded-xl bg-white p-3 text-primary shadow-2xl ring-1 ring-black/5 [text-shadow:none] xl:hidden">
            <ul class="space-y-1">
                @foreach($menu as $item)
                    @if(isset($item['children']))
                        <li class="px-3 pb-1 pt-3 text-xs font-bold uppercase tracking-wider text-slate-400">{{ $item['label'] }}</li>
                        @foreach($item['children'] as $child)
                            <li>
                                <a href="{{ $child['href'] }}" class="block rounded-lg px-3 py-3 pl-6 text-sm font-semibold transition hover:bg-sky/60 hover:text-accent">
                                    {{ $child['label'] }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li>
                            <a href="{{ $item['href'] }}"
                               class="block rounded-lg px-3 py-3 font-bold transition hover:bg-sky/60 hover:text-accent {{ request()->is($item['match']) ? 'text-accent' : '' }}">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</header>