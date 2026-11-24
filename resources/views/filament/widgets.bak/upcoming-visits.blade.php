<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-red-600 animate-pulse"></span>
                <span class="text-base font-bold text-slate-800">Kunjungan yang akan datang</span>
            </div>
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($upcomingVisits as $visit)
                <div class="bg-slate-50 border border-slate-200/80 rounded-lg p-3 hover:border-red-300 hover:shadow-sm transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-2 mb-1">
                            <h4 class="font-bold text-sm text-slate-800 leading-tight">
                                {{ $visit['institution'] }}
                            </h4>
                            <span class="px-2 py-0.5 text-[11px] font-semibold rounded-full shrink-0 {{ $visit['status'] === 'Dijadwalkan' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-amber-100 text-amber-800 border border-amber-200' }}">
                                {{ $visit['status'] }}
                            </span>
                        </div>
                        <div class="text-xs text-slate-500 font-medium flex items-center gap-2 mt-2">
                            <span>📅 {{ $visit['date'] }}</span>
                            <span>⏰ {{ $visit['time'] }}</span>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-t border-slate-200 text-xs font-semibold text-slate-600 flex justify-between">
                        <span>Jumlah Peserta:</span>
                        <span class="text-red-700 font-bold">{{ $visit['visitors'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
