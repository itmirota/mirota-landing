<?php

namespace App\Filament\Resources\VisitInstitutions;

use App\Filament\Concerns\RequiresFeature;
use App\Filament\Resources\VisitInstitutions\Pages\ManageVisitInstitutions;
use App\Models\VisitInstitution;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use UnitEnum;

class VisitInstitutionResource extends Resource
{
    use RequiresFeature;

    protected static function feature(): string
    {
        return 'visits';
    }

    protected static ?string $model = VisitInstitution::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static string|UnitEnum|null $navigationGroup = 'Kunjungan Industri';

    protected static ?string $navigationLabel = 'Instansi Pengunjung';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Instansi';

    protected static ?string $pluralModelLabel = 'Instansi Pengunjung';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nama instansi')
                ->required()
                ->maxLength(150),

            FileUpload::make('logo')
                ->label('Logo (opsional)')
                ->image()
                ->disk('public')
                ->directory('visits/institutions')
                ->visibility('public')
                ->maxSize(1024)
                ->helperText('Tanpa logo, web menampilkan nama instansi. Unggah logo dengan izin instansi yang bersangkutan.'),

            Toggle::make('is_published')
                ->label('Tampilkan di web')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')->label('Logo')->disk('public')->imageHeight(40),
                TextColumn::make('name')->label('Nama')->searchable(),
                ToggleColumn::make('is_published')->label('Tampil'),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make()
                    ->iconButton()
                    ->color('warning')
                    ->tooltip('Ubah Instansi'),
                DeleteAction::make()
                    ->iconButton()
                    ->color('danger')
                    ->tooltip('Hapus Instansi'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageVisitInstitutions::route('/'),
        ];
    }
}