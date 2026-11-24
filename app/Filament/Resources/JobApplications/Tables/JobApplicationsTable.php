<?php

namespace App\Filament\Resources\JobApplications\Tables;

use App\Filament\Resources\JobApplications\Schemas\JobApplicationForm;
use App\Models\JobApplication;
use App\Models\User;
use Filament\Actions\Action;
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
                    ->iconButton()
                    ->color('info')
                    ->tooltip('Lihat Detail')
                    ->modalHeading(
                        fn (JobApplication $record): string =>
                            'Lamaran: '.$record->name
                    )
                    ->modalDescription(
                        fn (JobApplication $record): string =>
                            'Masuk '.$record->created_at->translatedFormat('d F Y, H:i')
                    ),

                // Unduh CV hanya untuk pengguna yang memiliki izin applications.
                Action::make('cv')
                    ->label('Unduh CV')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->iconButton()
                    ->color('warning')
                    ->tooltip('Unduh CV')
                    ->action(function (JobApplication $record) {
                        $user = Filament::auth()->user();

                        abort_unless(
                            $user instanceof User && $user->canManage('applications'),
                            403
                        );

                        $disk = Storage::disk(config('filesystems.default'));

                        if (
                            ! $record->cv_path ||
                            ! $disk->exists($record->cv_path)
                        ) {
                            Notification::make()
                                ->title('File CV tidak ditemukan')
                                ->danger()
                                ->send();

                            return null;
                        }

                        $extension = pathinfo(
                            $record->cv_path,
                            PATHINFO_EXTENSION
                        );

                        $filename = 'CV-'
                            .Str::slug($record->name)
                            .'.'.$extension;

                        return response()->download(
                            $disk->path($record->cv_path),
                            $filename
                        );
                    }),

                Action::make('balas')
                    ->label('Balas')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->iconButton()
                    ->color('info')
                    ->tooltip('Kirim Email')
                    ->url(
                        fn (JobApplication $record): string =>
                            'https://mail.google.com/mail/?view=cm&fs=1'
                            .'&to='.rawurlencode($record->email)
                            .'&su='.rawurlencode('Lamaran Anda di PT Mirota KSM')
                    )
                    ->openUrlInNewTab(),

                DeleteAction::make()
                    ->iconButton()
                    ->color('danger')
                    ->tooltip('Hapus Lamaran'),
            ]);
    }
}
