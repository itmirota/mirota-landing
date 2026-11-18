<?php

namespace App\Filament\Resources\VisitVideos;

use App\Filament\Concerns\RequiresFeature;
use App\Filament\Resources\VisitVideos\Pages\ManageVisitVideos;
use App\Models\VisitVideo;
use App\Support\YouTube;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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

class VisitVideoResource extends Resource
{
    use RequiresFeature;

    protected static function feature(): string
    {
        return 'visits';
    }

    protected static ?string $model = VisitVideo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedVideoCamera;

    protected static string|UnitEnum|null $navigationGroup = 'Kunjungan Industri';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $modelLabel = 'Video Kunjungan';

    protected static ?string $pluralModelLabel = 'Video Kunjungan';

    protected static ?int $navigationSort = 62;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->label('Judul (ID)')
                ->required()
                ->maxLength(150),

            TextInput::make('title_en')
                ->label('Title (EN, opsional)')
                ->maxLength(150),

            TextInput::make('youtube_id')
                ->label('Tautan YouTube')
                ->required()
                ->helperText('Tempel tautan video dari YouTube (mis. https://www.youtube.com/watch?v=...).')
                ->rules([
                    fn (): \Closure => function (string $attribute, $value, \Closure $fail) {
                        if (! YouTube::id($value)) {
                            $fail('Tautan atau ID YouTube tidak valid.');
                        }
                    },
                ])
                ->dehydrateStateUsing(fn (?string $state): ?string => YouTube::id($state)),

            Toggle::make('is_published')
                ->label('Tampilkan di web')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumb')
                    ->label('Cuplikan')
                    ->state(fn (VisitVideo $record): string => 'https://img.youtube.com/vi/'.$record->youtube_id.'/mqdefault.jpg')
                    ->imageHeight(48),

                TextColumn::make('title')->label('Judul')->searchable()->wrap(),

                ToggleColumn::make('is_published')->label('Tampil'),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->recordActions([
                Action::make('tonton')
                    ->label('Tonton')
                    ->icon(Heroicon::OutlinedPlay)
                    ->url(fn (VisitVideo $record): string => 'https://www.youtube.com/watch?v='.$record->youtube_id)
                    ->openUrlInNewTab(),

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
            'index' => ManageVisitVideos::route('/'),
        ];
    }
}