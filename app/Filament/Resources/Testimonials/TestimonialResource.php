<?php

namespace App\Filament\Resources\Testimonials;

use App\Filament\Concerns\RequiresFeature;
use App\Filament\Resources\Testimonials\Pages\ManageTestimonials;
use App\Models\Testimonial;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
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

class TestimonialResource extends Resource
{
    use RequiresFeature;

    protected static function feature(): string
    {
        return 'maklon';
    }

    protected static ?string $model = Testimonial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static string|UnitEnum|null $navigationGroup = 'Maklon';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Testimoni';

    protected static ?string $pluralModelLabel = 'Testimoni';

    protected static ?int $navigationSort = 51;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(100),

            TextInput::make('position')
                ->label('Jabatan')
                ->maxLength(100),

            TextInput::make('company')
                ->label('Perusahaan')
                ->maxLength(150),

            Textarea::make('quote')
                ->label('Testimoni (ID)')
                ->required()
                ->rows(4),

            Textarea::make('quote_en')
                ->label('Testimonial (EN, opsional)')
                ->rows(4),

            FileUpload::make('photo')
                ->label('Foto (opsional)')
                ->image()
                ->disk('public')
                ->directory('testimonials')
                ->visibility('public')
                ->maxSize(1024)
                ->helperText('Tanpa foto, web menampilkan huruf pertama nama. Hanya unggah dengan izin yang bersangkutan.'),

            Toggle::make('is_published')
                ->label('Tampilkan di web')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')->label('Foto')->disk('public')->circular(),
                TextColumn::make('name')->label('Nama')->searchable(),
                TextColumn::make('company')->label('Perusahaan')->searchable(),
                TextColumn::make('quote')->label('Testimoni')->limit(60)->wrap(),
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
            'index' => ManageTestimonials::route('/'),
        ];
    }
}