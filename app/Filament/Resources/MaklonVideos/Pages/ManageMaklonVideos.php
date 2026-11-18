<?php

namespace App\Filament\Resources\MaklonVideos\Pages;

use App\Filament\Resources\MaklonVideos\MaklonVideoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMaklonVideos extends ManageRecords
{
    protected static string $resource = MaklonVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
