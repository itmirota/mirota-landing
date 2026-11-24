<x-filament-widgets::widget>
    <x-filament::section heading="Informasi Pengunjung Bulanan">
        <div class="mirota-monthly">
            <div class="mirota-monthly__filter">
                <label for="mirota-year">Tahun :</label>
                <x-filament::input.wrapper>
                    <x-filament::input.select id="mirota-year" wire:model="selectedYear">
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
                <x-filament::button size="sm" wire:click="applyFilter">
                    Filter
                </x-filament::button>
            </div>

            <table class="mirota-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th class="mirota-table__num">Pengunjung</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $row)
                        <tr>
                            <td>{{ $row['no'] }}</td>
                            <td>{{ $row['month'] }}</td>
                            <td class="mirota-table__num">{{ $row['count'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">Total</td>
                        <td class="mirota-table__num">{{ $total }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
