<?php

namespace App\Filament\Resources\VisitRequests\Tables;

use App\Filament\Resources\VisitRequests\Schemas\VisitRequestForm;
use App\Models\VisitRequest;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VisitRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('institution')
                    ->label('Instansi')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('institution_type')
                    ->label('Jenis')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (string $state): string => VisitRequestForm::TYPES[$state] ?? $state),

                TextColumn::make('visitors')
                    ->label('Peserta')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('preferred_date')
                    ->label('Rencana kunjungan')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('contact_name')
                    ->label('Penanggung jawab')
                    ->searchable(),

                SelectColumn::make('status')
                    ->label('Status')
                    ->options(VisitRequestForm::STATUSES)
                    ->selectablePlaceholder(false),

                TextColumn::make('created_at')
                    ->label('Diajukan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(VisitRequestForm::STATUSES),

                SelectFilter::make('institution_type')
                    ->label('Jenis instansi')
                    ->options(VisitRequestForm::TYPES),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Detail')
                    ->modalHeading(fn (VisitRequest $record): string => $record->institution)
                    ->modalDescription(fn (VisitRequest $record): string => 'Diajukan '.$record->created_at->translatedFormat('d F Y, H:i')),

                Action::make('balas')
                    ->label('Balas')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->url(fn (VisitRequest $record): string => 'mailto:'.$record->email.'?subject='.rawurlencode('Pengajuan Kunjungan Industri PT Mirota KSM'))
                    ->openUrlInNewTab(),

                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}