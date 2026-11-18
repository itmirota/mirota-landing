<?php

namespace App\Filament\Resources\Articles\Tables;

use App\Models\Article;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover')
                    ->label('Sampul')
                    ->disk('public')
                    ->imageHeight(48),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(70),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (string $state): string => __('article.categories.'.$state, [], 'id')),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->state(function (Article $record): string {
                        if (! $record->is_published) {
                            return 'Draf';
                        }

                        if ($record->published_at && $record->published_at->isFuture()) {
                            return 'Terjadwal';
                        }

                        return 'Tayang';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Tayang'    => 'success',
                        'Terjadwal' => 'warning',
                        default     => 'gray',
                    }),

                TextColumn::make('published_at')
                    ->label('Tanggal tayang')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(__('article.categories', [], 'id')),

                TernaryFilter::make('is_published')
                    ->label('Tayang'),
            ])
            ->recordActions([
                Action::make('lihat')
                    ->label('Lihat')
                    ->icon(Heroicon::OutlinedEye)
                    ->url(fn (Article $record): string => url('/id/artikel/'.$record->slug))
                    ->openUrlInNewTab()
                    ->visible(fn (Article $record): bool => $record->is_published
                        && (! $record->published_at || $record->published_at->isPast())),

                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}