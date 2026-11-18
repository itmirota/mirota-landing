<?php

namespace App\Filament\Resources\VisitPhotos;

use App\Filament\Concerns\RequiresFeature;
use App\Filament\Resources\VisitPhotos\Pages\ManageVisitPhotos;
use App\Models\VisitPhoto;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
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

class VisitPhotoResource extends Resource
{
    use RequiresFeature;

    protected static function feature(): string
    {
        return 'visits';
    }

    protected static ?string $model = VisitPhoto::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'Kunjungan Industri';

    protected static ?string $recordTitleAttribute = 'caption';

    protected static ?string $modelLabel = 'Foto Kunjungan';

    protected static ?string $pluralModelLabel = 'Galeri Kunjungan';

    protected static ?int $navigationSort = 60;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('image')
                ->label('Foto')
                ->image()
                ->required()
                ->disk('public')
                ->directory('visits')
                ->visibility('public')
                ->maxSize(3072)
                ->helperText('Rasio lanskap 4:3 paling pas. Kompres foto dulu (idealnya di bawah 500 KB). Pastikan sekolah atau instansi mengizinkan fotonya ditampilkan.'),

            TextInput::make('caption')
                ->label('Keterangan (ID)')
                ->maxLength(150),

            TextInput::make('caption_en')
                ->label('Caption (EN, opsional)')
                ->maxLength(150),

            DatePicker::make('visited_at')
                ->label('Tanggal kunjungan'),

            Toggle::make('is_published')
                ->label('Tampilkan di web')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('Foto')->disk('public')->imageHeight(48),
                TextColumn::make('caption')->label('Keterangan')->searchable()->wrap(),
                TextColumn::make('visited_at')->label('Tanggal')->date('d M Y')->sortable(),
                ToggleColumn::make('is_published')->label('Tampil'),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageVisitPhotos::route('/'),
        ];
    }
}