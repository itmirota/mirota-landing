<?php

namespace App\Filament\Widgets;

use App\Support\VisitorData;
use Filament\Widgets\Widget;

class MonthlyVisitorsWidget extends Widget
{
    protected string $view = 'filament.widgets.monthly-visitors';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = [
        'default' => 1,
        'lg' => 1,
    ];

    /** Tahun yang dipilih di dropdown. */
    public string $selectedYear = '';

    /** Tahun yang sedang ditampilkan di tabel (berubah saat tombol Filter ditekan). */
    public string $appliedYear = '';

    public function mount(): void
    {
        $this->selectedYear = (string) now()->year;
        $this->appliedYear = $this->selectedYear;
    }

    public function applyFilter(): void
    {
        $this->appliedYear = $this->selectedYear;
    }

    protected function getViewData(): array
    {
        $values = VisitorData::monthly((int) $this->appliedYear);
        $rows = [];

        foreach (VisitorData::monthNames() as $index => $name) {
            $rows[] = [
                'no' => $index + 1,
                'month' => $name,
                'count' => VisitorData::format($values[$index] ?? 0),
            ];
        }

        return [
            'rows' => $rows,
            'total' => VisitorData::format(array_sum($values)),
            'years' => VisitorData::years(),
        ];
    }
}
