<?php

namespace App\Filament\Resources\JobApplications\Tables;

use App\Filament\Resources\JobApplications\Schemas\JobApplicationForm;
use App\Models\JobApplication;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
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

class JobApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),

                TextColumn::make('job.title')
                    ->label('Posisi')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email disalin'),

                TextColumn::make('phone')
                    ->label('Telepon')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                SelectColumn::make('status')
                    ->label('Status')
                    ->options(JobApplicationForm::STATUSES)
                    ->selectablePlaceholder(false),

                TextColumn::make('created_at')
                    ->label('Melamar')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('job_vacancy_id')
                    ->label('Posisi')
                    ->relationship('job', 'title'),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options(JobApplicationForm::STATUSES),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Detail')
                    ->modalHeading(fn (JobApplication $record): string => 'Lamaran: '.$record->name)
                    ->modalDescription(fn (JobApplication $record): string => 'Masuk '.$record->created_at->translatedFormat('d F Y, H:i')),

                // Berkas tersimpan di disk privat; hanya bisa diunduh lewat tombol ini oleh yang berizin.
                ActionGroup::make([
                    Action::make('cv')
                        ->label('Unduh CV')
                        ->icon(Heroicon::OutlinedArrowDownTray)
                        ->visible(fn (JobApplication $record): bool => filled($record->cv_path))
                        ->action(fn (JobApplication $record) => self::download($record, 'cv_path', 'CV')),

                    Action::make('ijazah')
                        ->label('Unduh Ijazah')
                        ->icon(Heroicon::OutlinedAcademicCap)
                        ->visible(fn (JobApplication $record): bool => filled($record->diploma_path))
                        ->action(fn (JobApplication $record) => self::download($record, 'diploma_path', 'Ijazah')),

                    Action::make('lampiran')
                        ->label('Unduh Lampiran')
                        ->icon(Heroicon::OutlinedPaperClip)
                        ->visible(fn (JobApplication $record): bool => filled($record->attachment_path))
                        ->action(fn (JobApplication $record) => self::download($record, 'attachment_path', 'Lampiran')),
                ])
                    ->label('Berkas')
                    ->icon(Heroicon::OutlinedFolderArrowDown)
                    ->button(),

                Action::make('balas')
                    ->label('Balas')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->url(fn (JobApplication $record): string => 'https://mail.google.com/mail/?view=cm&fs=1'
                        .'&to='.rawurlencode($record->email)
                        .'&su='.rawurlencode('Lamaran Anda di PT Mirota KSM'))
                    ->openUrlInNewTab(),

                DeleteAction::make(),
            ]);
    }

    protected static function download(JobApplication $record, string $column, string $prefix)
    {
        /** @var User|null $user */
        $user = Filament::auth()->user();
        abort_unless($user?->canManage('applications'), 403);

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk(config('filesystems.default'));
        $path = $record->{$column};

        if (! $path || ! $disk->exists($path)) {
            Notification::make()->title('File tidak ditemukan')->danger()->send();

            return null;
        }

        return $disk->download(
            $path,
            $prefix.'-'.Str::slug($record->name).'.'.pathinfo($path, PATHINFO_EXTENSION)
        );
    }
}