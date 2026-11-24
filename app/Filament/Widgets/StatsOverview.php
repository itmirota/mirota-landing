<?php

namespace App\Filament\Widgets;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\VisitRequest;
use Filament\Widgets\Widget;

class StatsOverview extends Widget
{
    protected string $view = 'filament.widgets.summary-cards';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = [
        'default' => 1,
        'lg' => 2,
    ];

    protected function getViewData(): array
    {
        return [
            'cards' => [
                [
                    'label' => 'Total Pelamar',
                    'value' => number_format(JobApplication::count()),
                    'icon' => 'heroicon-o-user-group',
                ],
                [
                    'label' => 'Lowongan Aktif',
                    'value' => number_format(JobVacancy::where('is_published', true)->count()),
                    'icon' => 'heroicon-o-briefcase',
                ],
                [
                    'label' => 'Rencana Kunjungan',
                    'value' => number_format(VisitRequest::whereIn('status', ['new', 'contacted', 'scheduled'])->count()),
                    'icon' => 'heroicon-o-calendar-days',
                ],
                [
                    'label' => 'Kunjungan Selesai',
                    'value' => number_format(VisitRequest::where('status', 'completed')->count()),
                    'icon' => 'heroicon-o-check-circle',
                ],
            ],
        ];
    }
}
