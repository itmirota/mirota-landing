<?php

namespace App\Filament\Resources\MaklonVideos;

use App\Filament\Concerns\RequiresFeature;
use App\Filament\Resources\MaklonVideos\Pages\ManageMaklonVideos;
use App\Models\MaklonVideo;
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

class MaklonVideoResource extends Resource
{
    use RequiresFeature;

    protected static function feature(): string
    {
        return 'maklon';
    }

    protected static ?string $model = MaklonVideo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPlayCircle;

    protected static string|UnitEnum|null $navigationGroup = 'Maklon';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $modelLabel = 'Video Maklon';

    protected static ?string $pluralModelLabel = 'Video Maklon';

    protected static ?int $navigationSort = 52;

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
                    ->state(fn (MaklonVideo $record): string => 'https://img.youtube.com/vi/'.$record->youtube_id.'/mqdefault.jpg')
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
                    ->iconButton()
                    ->color('info')
                    ->tooltip('Tonton Video')
                    ->url(fn (MaklonVideo $record): string => 'https://www.youtube.com/watch?v='.$record->youtube_id)
                    ->openUrlInNewTab(),

                EditAction::make()
                    ->iconButton()
                    ->color('warning')
                    ->tooltip('Ubah Video'),
                DeleteAction::make()
                    ->iconButton()
                    ->color('danger')
                    ->tooltip('Hapus Video'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMaklonVideos::route('/'),
        ];
    }
}