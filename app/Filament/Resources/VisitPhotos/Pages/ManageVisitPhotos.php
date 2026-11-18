<?php

namespace App\Filament\Resources\VisitPhotos\Pages;

use App\Filament\Resources\VisitPhotos\VisitPhotoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageVisitPhotos extends ManageRecords
{
    protected static string $resource = VisitPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
