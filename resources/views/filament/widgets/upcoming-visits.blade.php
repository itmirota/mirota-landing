<x-filament-widgets::widget>
    <x-filament::section heading="Kunjungan yang akan datang" icon="heroicon-o-calendar">
        @forelse ($upcomingVisits as $visit)
            <div class="mirota-visit-row">
                <div class="mirota-visit-row__name">{{ $visit['institution'] }}</div>
                <div class="mirota-visit-row__meta">{{ $visit['date'] }} {{ $visit['time'] }}</div>
            </div>
        @empty
            <div class="mirota-visit-empty">Belum ada kunjungan yang dijadwalkan.</div>
        @endforelse
    </x-filament::section>
</x-filament-widgets::widget>
