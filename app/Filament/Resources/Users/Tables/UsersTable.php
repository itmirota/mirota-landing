<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('role')
                    ->label('Peran')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'superadmin' ? 'Superadmin' : 'Admin Fitur')
                    ->color(fn (string $state): string => $state === 'superadmin' ? 'danger' : 'info'),

                TextColumn::make('akses')
                    ->label('Akses fitur')
                    ->state(function (User $record): string {
                        if ($record->isSuperadmin()) {
                            return 'Semua fitur';
                        }

                        $labels = collect($record->permissions ?? [])
                            ->map(fn (string $key) => config("admin.features.$key"))
                            ->filter();

                        return $labels->isEmpty() ? 'Belum ada akses' : $labels->join(', ');
                    })
                    ->wrap(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->recordActions([
                ViewAction::make()
                    ->iconButton()
                    ->color('info')
                    ->tooltip('Detail Pengguna'),

                EditAction::make()
                    ->iconButton()
                    ->color('warning')
                    ->tooltip('Ubah Pengguna'),

                DeleteAction::make()
                    ->iconButton()
                    ->color('danger')
                    ->tooltip('Hapus Pengguna')
                    ->visible(fn (User $record): bool => ! $record->isSuperadmin()),
            ]);
    }
}
