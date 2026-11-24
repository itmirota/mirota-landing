<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Product;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Foto')
                    ->disk('public')
                    ->square(),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name_en')
                    ->label('Nama (EN)')
                    ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('is_featured')
                    ->label('Unggulan'),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                TernaryFilter::make('is_featured')->label('Produk unggulan'),
            ])
            ->recordActions([
                Action::make('lihat')
                    ->label('Lihat')
                    ->icon(Heroicon::OutlinedEye)
                    ->iconButton()
                    ->color('info')
                    ->tooltip('Lihat Produk')
                    ->url(fn (Product $record): string => url('/id/produk/'.$record->slug))
                    ->openUrlInNewTab(),

                EditAction::make()
                    ->iconButton()
                    ->color('warning')
                    ->tooltip('Ubah Produk'),

                DeleteAction::make()
                    ->iconButton()
                    ->color('danger')
                    ->tooltip('Hapus Produk'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}