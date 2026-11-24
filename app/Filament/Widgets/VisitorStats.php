<?php

namespace App\Filament\Widgets;

use App\Support\VisitorData;
use Filament\Widgets\Widget;

class VisitorStats extends Widget
{
    protected string $view = 'filament.widgets.visitor-stats';

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $year = (int) now()->year;

        return [
            'stats' => [
                ['label' => 'Pengunjung Hari Ini', 'value' => VisitorData::format(VisitorData::today())],
                ['label' => 'Pengunjung Bulan Ini', 'value' => VisitorData::format(VisitorData::thisMonth())],
                ['label' => 'Pengunjung Tahun ' . $year, 'value' => VisitorData::format(VisitorData::total($year))],
            ],
        ];
    }
}
