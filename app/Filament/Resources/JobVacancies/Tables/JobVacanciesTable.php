<?php

namespace App\Filament\Resources\JobVacancies\Tables;

use App\Models\JobVacancy;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class JobVacanciesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Posisi')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('department')
                    ->label('Bagian')
                    ->toggleable(),

                TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (string $state): string => __('career.types.'.$state, [], 'id')),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->state(function (JobVacancy $record): string {
                        if (! $record->is_published) {
                            return 'Draf';
                        }

                        if ($record->published_at && $record->published_at->isFuture()) {
                            return 'Terjadwal';
                        }

                        if ($record->closing_date && $record->closing_date->lt(today())) {
                            return 'Ditutup';
                        }

                        return 'Dibuka';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Dibuka'    => 'success',
                        'Terjadwal' => 'warning',
                        'Ditutup'   => 'danger',
                        default     => 'gray',
                    }),

                TextColumn::make('closing_date')
                    ->label('Batas daftar')
                    ->date('d M Y')
                    ->placeholder('Tanpa batas')
                    ->sortable(),

                TextColumn::make('applications_count')
                    ->label('Pelamar')
                    ->counts('applications')
                    ->badge(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->label('Jenis')
                    ->options(__('career.types', [], 'id')),
            ])
            ->recordActions([
                Action::make('lihat')
                    ->label('Lihat')
                    ->icon(Heroicon::OutlinedEye)
                    ->iconButton()
                    ->color('info')
                    ->tooltip('Lihat Lowongan')
                    ->url(fn (JobVacancy $record): string => url('/id/karir/lowongan/'.$record->slug))
                    ->openUrlInNewTab(),

                EditAction::make()
                    ->iconButton()
                    ->color('warning')
                    ->tooltip('Ubah Data'),

                // Lowongan yang sudah punya pelamar tidak boleh dihapus (data pelamar ikut hilang).
                // Cukup matikan "Tayangkan" untuk menutupnya.
                DeleteAction::make()
                    ->iconButton()
                    ->color('danger')
                    ->tooltip('Hapus Data')
                    ->visible(fn (JobVacancy $record): bool => ! $record->applications()->exists()),
            ]);
    }
}