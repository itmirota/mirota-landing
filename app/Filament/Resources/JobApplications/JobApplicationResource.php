<?php

namespace App\Filament\Resources\JobApplications;

use App\Filament\Concerns\RequiresFeature;
use App\Filament\Resources\JobApplications\Pages\ListJobApplications;
use App\Filament\Resources\JobApplications\Schemas\JobApplicationForm;
use App\Filament\Resources\JobApplications\Tables\JobApplicationsTable;
use App\Models\JobApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JobApplicationResource extends Resource
{
    use RequiresFeature;

    // Fitur terpisah dari "careers": berisi data pribadi pelamar.
    protected static function feature(): string
    {
        return 'applications';
    }

    protected static ?string $model = JobApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|\UnitEnum|null $navigationGroup = 'Karir';

    protected static ?string $navigationLabel = 'Data Pelamar';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Data Pelamar';

    protected static ?string $pluralModelLabel = 'Data Pelamar';

    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        $new = JobApplication::where('status', 'new')->count();

        return $new > 0 ? (string) $new : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return JobApplicationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobApplicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJobApplications::route('/'),
        ];
    }
}