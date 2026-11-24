<x-filament-widgets::widget>
    <div class="mirota-summary-cards">
        @foreach ($cards as $card)
            <div class="mirota-card mirota-summary-card">
                <div class="mirota-summary-card__icon">
                    <x-filament::icon :icon="$card['icon']" class="mirota-icon" />
                </div>
                <div>
                    <div class="mirota-summary-card__label">{{ $card['label'] }}</div>
                    <div class="mirota-summary-card__value">{{ $card['value'] }}</div>
                </div>
            </div>
        @endforeach
    </div>
</x-filament-widgets::widget>
