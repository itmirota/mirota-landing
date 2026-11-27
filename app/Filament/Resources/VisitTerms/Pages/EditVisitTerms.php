<?php

namespace App\Filament\Resources\VisitTerms\Pages;

use App\Filament\Resources\VisitTerms\VisitTermResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditVisitTerms extends EditRecord
{
    protected static string $resource = VisitTermResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Syarat & Ketentuan Kunjungan';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}