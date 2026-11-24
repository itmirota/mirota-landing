<?php

namespace App\Filament\Resources\JobVacancies;

use App\Filament\Concerns\RequiresFeature;
use App\Filament\Resources\JobVacancies\Pages\CreateJobVacancy;
use App\Filament\Resources\JobVacancies\Pages\EditJobVacancy;
use App\Filament\Resources\JobVacancies\Pages\ListJobVacancies;
use App\Filament\Resources\JobVacancies\Schemas\JobVacancyForm;
use App\Filament\Resources\JobVacancies\Tables\JobVacanciesTable;
use App\Models\JobVacancy;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JobVacancyResource extends Resource
{
    use RequiresFeature;

    protected static function feature(): string
    {
        return 'careers';
    }

    protected static ?string $model = JobVacancy::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static string|\UnitEnum|null $navigationGroup = 'Karir';

    protected static ?string $navigationLabel = 'Data Lowongan Kerja';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $modelLabel = 'Lowongan Kerja';

    protected static ?string $pluralModelLabel = 'Data Lowongan Kerja';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return JobVacancyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobVacanciesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJobVacancies::route('/'),
            'create' => CreateJobVacancy::route('/create'),
            'edit' => EditJobVacancy::route('/{record}/edit'),
        ];
    }
}