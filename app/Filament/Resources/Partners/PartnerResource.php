<?php

namespace App\Filament\Resources\Partners;

use App\Filament\Concerns\RequiresFeature;
use App\Filament\Resources\Partners\Pages\ManagePartners;
use App\Models\Partner;
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

class PartnerResource extends Resource
{
    use RequiresFeature;

    protected static function feature(): string
    {
        return 'maklon';
    }

    protected static ?string $model = Partner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|UnitEnum|null $navigationGroup = 'Maklon';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Mitra';

    protected static ?string $pluralModelLabel = 'Mitra';

    protected static ?int $navigationSort = 50;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nama perusahaan')
                ->required()
                ->maxLength(150),

            FileUpload::make('logo')
                ->label('Logo')
                ->image()
                ->disk('public')
                ->directory('partners')
                ->visibility('public')
                ->maxSize(1024)
                ->helperText('PNG/JPG/WebP, maks. 1 MB. Latar putih atau transparan. Pastikan mitra sudah mengizinkan logonya ditampilkan.'),

            TextInput::make('website')
                ->label('Situs web (opsional)')
                ->url()
                ->maxLength(200),

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
                    ->tooltip('Ubah Mitra'),
                DeleteAction::make()
                    ->iconButton()
                    ->color('danger')
                    ->tooltip('Hapus Mitra'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePartners::route('/'),
        ];
    }
}