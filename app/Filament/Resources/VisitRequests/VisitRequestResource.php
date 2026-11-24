<?php

namespace App\Filament\Resources\VisitRequests;

use App\Filament\Concerns\RequiresFeature;
use App\Filament\Resources\VisitRequests\Pages\ListVisitRequests;
use App\Filament\Resources\VisitRequests\Schemas\VisitRequestForm;
use App\Filament\Resources\VisitRequests\Tables\VisitRequestsTable;
use App\Models\VisitRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class VisitRequestResource extends Resource
{
    use RequiresFeature;

    protected static function feature(): string
    {
        return 'visits';
    }

    protected static ?string $model = VisitRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string|UnitEnum|null $navigationGroup = 'Kunjungan Industri';

    protected static ?string $navigationLabel = 'Data Kunjungan';

    protected static ?string $recordTitleAttribute = 'institution';

    protected static ?string $modelLabel = 'Data Kunjungan';

    protected static ?string $pluralModelLabel = 'Data Kunjungan';

    protected static ?int $navigationSort = 1;

    // Pengajuan hanya masuk dari formulir publik.
    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        $new = VisitRequest::where('status', 'new')->count();

        return $new > 0 ? (string) $new : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return VisitRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VisitRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVisitRequests::route('/'),
        ];
    }
}