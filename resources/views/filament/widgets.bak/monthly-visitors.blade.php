<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span class="text-base font-bold text-slate-800">Informasi Pengunjung Bulanan</span>
                <div class="flex items-center gap-2 text-xs">
                    <span class="text-slate-500 font-medium">Tahun:</span>
                    <span class="font-bold text-red-600 bg-red-50 border border-red-200 px-2 py-0.5 rounded">{{ $selectedYear }}</span>
                </div>
            </div>
        </x-slot>

        <div class="overflow-x-auto max-h-72 overflow-y-auto">
            <table class="w-full text-xs text-left">
                <thead class="text-slate-600 uppercase bg-slate-100 border-b border-slate-200 sticky top-0">
                    <tr>
                        <th class="px-3 py-2 w-12 text-center">No</th>
                        <th class="px-3 py-2">Bulan</th>
                        <th class="px-3 py-2 text-right">Pengunjung</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($monthlyData as $row)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-3 py-1.5 text-center text-slate-500 font-medium">{{ $row['no'] }}</td>
                            <td class="px-3 py-1.5 text-slate-700 font-medium">{{ $row['month'] }}</td>
                            <td class="px-3 py-1.5 text-right font-mono font-semibold text-slate-800">{{ $row['count'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-slate-100 border-t-2 border-slate-300 font-bold sticky bottom-0">
                    <tr>
                        <td colspan="2" class="px-3 py-2 text-slate-800">Total</td>
                        <td class="px-3 py-2 text-right font-mono text-red-700">{{ $total }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
