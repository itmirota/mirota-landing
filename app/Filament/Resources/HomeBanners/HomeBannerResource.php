<?php

namespace App\Filament\Resources\HomeBanners;

use App\Filament\Concerns\RequiresFeature;
use App\Filament\Resources\HomeBanners\Pages\ManageHomeBanners;
use App\Models\HomeBanner;
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

class HomeBannerResource extends Resource
{
    use RequiresFeature;

    protected static function feature(): string
    {
        return 'banners';
    }

    protected static ?string $model = HomeBanner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $recordTitleAttribute = 'alt';

    protected static ?string $modelLabel = 'Banner';

    protected static ?string $pluralModelLabel = 'Banner Beranda';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('image')
                ->label('Foto banner (desktop)')
                ->image()
                ->required()
                ->disk('public')
                ->directory('banners')
                ->visibility('public')
                ->maxSize(2048)
                ->helperText('Rasio 2:1, ukuran 2400×1200 px. Taruh teks dan produk di bagian tengah (sisi kiri-kanan bisa terpotong di layar sempit). Kompres dulu (idealnya di bawah 500 KB), maks. 2 MB.'),

            FileUpload::make('image_mobile')
                ->label('Foto banner khusus HP (opsional)')
                ->image()
                ->disk('public')
                ->directory('banners')
                ->visibility('public')
                ->maxSize(2048)
                ->helperText('Rasio 4:5, ukuran 1080×1350 px. Jika kosong, HP memakai foto desktop yang dipotong bagian tengahnya.'),

            TextInput::make('alt')
                ->label('Deskripsi gambar')
                ->maxLength(150)
                ->helperText('Dibaca pembaca layar dan mesin pencari. Mis. "Lactona Skim, susu skim bubuk rendah lemak".'),

            TextInput::make('link')
                ->label('Tautan (opsional)')
                ->url()
                ->maxLength(255)
                ->helperText('Jika diisi, banner bisa diklik ke alamat ini (tulis alamat lengkap, diawali https://).'),

            Toggle::make('is_published')
                ->label('Tampilkan di web')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('Banner')->disk('public')->imageHeight(60),
                TextColumn::make('alt')->label('Deskripsi')->wrap()->placeholder('-'),
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
            'index' => ManageHomeBanners::route('/'),
        ];
    }
}