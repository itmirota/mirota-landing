<?php

namespace App\Filament\Resources\VisitInstitutions\Pages;

use App\Filament\Resources\VisitInstitutions\VisitInstitutionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageVisitInstitutions extends ManageRecords
{
    protected static string $resource = VisitInstitutionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
