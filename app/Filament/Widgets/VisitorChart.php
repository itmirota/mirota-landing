<?php

namespace App\Filament\Widgets;

use App\Support\VisitorData;
use Filament\Widgets\ChartWidget;

class VisitorChart extends ChartWidget
{
    protected ?string $heading = 'Informasi Pengunjung Website';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = [
        'default' => 1,
        'lg' => 2,
    ];

    protected ?string $maxHeight = '280px';

    protected function getFilters(): ?array
    {
        $filters = [];

        foreach (VisitorData::years() as $year) {
            $filters[(string) $year] = 'Tahun ' . $year;
        }

        return $filters;
    }

    protected function getData(): array
    {
        $year = (int) ($this->filter ?: now()->year);

        return [
            'datasets' => [
                [
                    'label' => 'Pengunjung',
                    'data' => VisitorData::monthly($year),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.12)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
