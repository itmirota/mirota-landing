<?php

namespace App\Filament\Resources\VisitVideos\Pages;

use App\Filament\Resources\VisitVideos\VisitVideoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageVisitVideos extends ManageRecords
{
    protected static string $resource = VisitVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
