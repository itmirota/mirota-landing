<?php

namespace App\Filament\Widgets;

use App\Models\VisitRequest;
use Filament\Widgets\Widget;

class UpcomingVisitsWidget extends Widget
{
    protected string $view = 'filament.widgets.upcoming-visits';

    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = [
        'default' => 1,
        'lg' => 2,
    ];

    protected function getViewData(): array
    {
        return [
            'upcomingVisits' => $this->getUpcomingVisits(),
        ];
    }

    public function getUpcomingVisits(): array
    {
        $visits = VisitRequest::query()
            ->whereIn('status', ['new', 'contacted', 'scheduled'])
            ->orderBy('preferred_date', 'asc')
            ->take(5)
            ->get();

        return $visits->map(function ($v) {
            return [
                'institution' => $v->institution,
                'date' => $v->preferred_date ? $v->preferred_date->translatedFormat('d F Y') : '-',
                'time' => $v->preferred_date ? $v->preferred_date->format('H.i') . ' WIB' : '-',
                'visitors' => ($v->visitors ?? 0) . ' Orang',
                'status' => match ($v->status) {
                    'scheduled' => 'Dijadwalkan',
                    'contacted' => 'Dihubungi',
                    'completed' => 'Selesai',
                    default => 'Pending',
                },
            ];
        })->toArray();
    }
}
