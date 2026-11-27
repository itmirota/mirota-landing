<?php

namespace App\Filament\Resources\VisitTerms\Pages;

use App\Filament\Resources\VisitTerms\VisitTermResource;
use App\Models\VisitTermsPage;
use Filament\Resources\Pages\ListRecords;

class ListVisitTerms extends ListRecords
{
    protected static string $resource = VisitTermResource::class;

    public function mount(): void
    {
        parent::mount();

        $this->redirect(
            VisitTermResource::getUrl('edit', ['record' => VisitTermsPage::instance()])
        );
    }
}