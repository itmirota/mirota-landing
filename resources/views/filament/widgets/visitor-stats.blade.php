<x-filament-widgets::widget>
    <div class="mirota-visitor-stats">
        @foreach ($stats as $stat)
            <div class="mirota-card mirota-visitor-stat">
                <div class="mirota-visitor-stat__label">{{ $stat['label'] }}</div>
                <div class="mirota-visitor-stat__value">
                    <x-filament::icon icon="heroicon-o-chart-bar" class="mirota-icon" />
                    <span>{{ $stat['value'] }}</span>
                </div>
            </div>
        @endforeach
    </div>
</x-filament-widgets::widget>
