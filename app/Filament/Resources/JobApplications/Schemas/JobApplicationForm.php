<?php

namespace App\Filament\Resources\JobApplications\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JobApplicationForm
{
    public const STATUSES = [
        'new'       => 'Baru',
        'reviewed'  => 'Ditinjau',
        'interview' => 'Wawancara',
        'rejected'  => 'Ditolak',
        'hired'     => 'Diterima',
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Pelamar')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('job_vacancy_id')
                        ->label('Posisi yang dilamar')
                        ->formatStateUsing(fn ($state, $record): string => $record?->job?->title ?? '-')
                        ->columnSpanFull(),

                    TextInput::make('name')->label('Nama'),

                    TextInput::make('status')
                        ->label('Status')
                        ->formatStateUsing(fn ($state, $record): string => self::STATUSES[$record?->status] ?? '-'),

                    TextInput::make('email')->label('Email'),

                    TextInput::make('phone')->label('Telepon / WhatsApp'),
                ]),

            Section::make('Surat Lamaran')
                ->columnSpanFull()
                ->schema([
                    Textarea::make('cover_letter')
                        ->label('Isi')
                        ->rows(8)
                        ->placeholder('Pelamar tidak menulis surat lamaran.'),
                ]),
        ]);
    }
}