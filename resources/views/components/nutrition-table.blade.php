@props(['nutrition'])

@if(!empty($nutrition['items']))
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="bg-primary px-5 py-3 text-white">
            <h3 class="font-bold">{{ __('product.nutrition_facts') }}</h3>
            @if(!empty($nutrition['serving_size']))
                <p class="text-xs text-white/80">{{ __('product.serving_size') }}: {{ $nutrition['serving_size'] }}</p>
            @endif
        </div>

        <table class="w-full text-sm">
            <tbody>
                @foreach($nutrition['items'] as $item)
                    <tr class="{{ $loop->even ? 'bg-sky/40' : 'bg-white' }}">
                        <td class="px-5 py-2.5 text-slate-700">
                            {{ app()->getLocale() === 'en' ? ($item['label_en'] ?? $item['label_id'] ?? '') : ($item['label_id'] ?? '') }}
                        </td>
                        <td class="px-5 py-2.5 text-right font-semibold text-primary-dark">{{ $item['value'] ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif