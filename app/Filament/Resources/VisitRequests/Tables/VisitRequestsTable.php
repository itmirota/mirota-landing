<?php

namespace App\Filament\Resources\VisitRequests\Tables;

use App\Filament\Resources\VisitRequests\Schemas\VisitRequestForm;
use App\Models\User;
use App\Models\VisitRequest;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

                TextColumn::make('province')
                    ->label('Provinsi')
                    ->toggleable(),

                TextColumn::make('visitors')
                    ->label('Peserta')
                    ->description(fn (VisitRequest $record): string => '+ '.$record->companions.' pendamping')
                    ->sortable(),

                TextColumn::make('preferred_date')
                    ->label('Rencana kunjungan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->searchable(query: fn ($query, string $search) => \App\Support\DateSearch::apply($query, 'preferred_date', $search)),

                TextColumn::make('contact_name')
                    ->label('Penanggung jawab')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->copyable()
                    ->copyMessage('Email disalin')
                    ->toggleable(isToggledHiddenByDefault: true),

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

                SelectFilter::make('province')
                    ->label('Provinsi')
                    ->options(array_combine(config('provinces'), config('provinces'))),

                SelectFilter::make('source')
                    ->label('Sumber info')
                    ->options(VisitRequestForm::SOURCES),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Detail')
                    ->iconButton()
                    ->color('info')
                    ->tooltip('Lihat Detail')
                    ->modalHeading(fn (VisitRequest $record): string => $record->institution)
                    ->modalDescription(fn (VisitRequest $record): string => 'Diajukan '.$record->created_at->translatedFormat('d F Y, H:i')),

                Action::make('surat')
                    ->label('Unduh surat')
                    ->icon(Heroicon::OutlinedDocumentArrowDown)
                    ->iconButton()
                    ->color('warning')
                    ->tooltip('Unduh Surat Pengajuan')
                    ->visible(fn (VisitRequest $record): bool => filled($record->letter_path))
                    ->action(fn (VisitRequest $record) => self::download($record, 'letter_path', 'surat')),

                Action::make('ktp')
                    ->label('Unduh foto KTP')
                    ->icon(Heroicon::OutlinedIdentification)
                    ->iconButton()
                    ->color('warning')
                    ->tooltip('Unduh Foto KTP')
                    ->visible(fn (VisitRequest $record): bool => filled($record->ktp_photo_path))
                    ->action(fn (VisitRequest $record) => self::download($record, 'ktp_photo_path', 'ktp')),

                Action::make('balas')
                    ->label('Balas')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->iconButton()
                    ->color('info')
                    ->tooltip('Balas Email')
                    ->url(fn (VisitRequest $record): string => 'https://mail.google.com/mail/?view=cm&fs=1'
                        .'&to='.rawurlencode($record->email)
                        .'&su='.rawurlencode('Pengajuan Kunjungan Industri PT Mirota KSM'))
                    ->openUrlInNewTab(),

                DeleteAction::make()
                    ->iconButton()
                    ->color('danger')
                    ->tooltip('Hapus Kunjungan'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    // Berkas tersimpan di disk privat; hanya bisa diunduh lewat tombol ini oleh yang berizin.
    protected static function download(VisitRequest $record, string $column, string $prefix)
    {
        /** @var User|null $user */
        $user = Filament::auth()->user();
        abort_unless($user?->canManage('visits'), 403);

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk(config('filesystems.default'));
        $path = $record->{$column};

        if (! $path || ! $disk->exists($path)) {
            Notification::make()->title('File tidak ditemukan')->danger()->send();

            return null;
        }

        return $disk->download(
            $path,
            $prefix.'-'.Str::slug($record->institution).'.'.pathinfo($path, PATHINFO_EXTENSION)
        );
    }
}