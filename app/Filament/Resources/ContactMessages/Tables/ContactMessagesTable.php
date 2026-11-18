<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use App\Models\ContactMessage;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('read_at')
                    ->label('Dibaca')
                    ->boolean(),

                TextColumn::make('type')
                    ->label('Untuk')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'maklon' ? 'Maklon' : 'Customer Care')
                    ->color(fn (string $state): string => $state === 'maklon' ? 'warning' : 'info'),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('company')
                    ->label('Perusahaan')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('message')
                    ->label('Pesan')
                    ->limit(60)
                    ->wrap(),

                TextColumn::make('created_at')
                    ->label('Diterima')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordClasses(fn (ContactMessage $record): ?string => $record->read_at ? null : 'font-semibold')
            ->filters([
                TernaryFilter::make('read_at')
                    ->label('Status baca')
                    ->nullable()
                    ->trueLabel('Sudah dibaca')
                    ->falseLabel('Belum dibaca'),

                SelectFilter::make('type')
                    ->label('Ditujukan ke')
                    ->options([
                        'customer_care' => 'Customer Care',
                        'maklon'        => 'Maklon',
                    ]),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Baca')
                    ->modalHeading(fn (ContactMessage $record): string => 'Pesan dari '.$record->name)
                    ->modalDescription(fn (ContactMessage $record): string => 'Diterima '.$record->created_at->translatedFormat('d F Y, H:i')),

                Action::make('balas')
                    ->label('Balas')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->url(fn (ContactMessage $record): string => 'mailto:'.$record->email.'?subject='.rawurlencode('Re: Pesan Anda kepada PT Mirota KSM'))
                    ->openUrlInNewTab(),

                Action::make('toggleRead')
                    ->label(fn (ContactMessage $record): string => $record->read_at ? 'Tandai belum dibaca' : 'Tandai sudah dibaca')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->action(fn (ContactMessage $record) => $record->update([
                        'read_at' => $record->read_at ? null : now(),
                    ])),

                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('markRead')
                        ->label('Tandai sudah dibaca')
                        ->icon(Heroicon::OutlinedCheckCircle)
                        ->action(fn (Collection $records) => $records->each->update(['read_at' => now()]))
                        ->deselectRecordsAfterCompletion(),

                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}