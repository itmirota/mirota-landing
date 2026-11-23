<?php

namespace App\Filament\Resources\VisitRequests\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VisitRequestForm
{
    public const SOURCES = [
        'ad'          => 'Iklan',
        'website'     => 'Website',
        'referral'    => 'Kerabat/rekan kerja',
        'mirota_team' => 'Tim Mirota',
    ];

    public const STATUSES = [
        'new'       => 'Baru',
        'confirmed' => 'Dikonfirmasi',
        'done'      => 'Selesai',
        'rejected'  => 'Ditolak',
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Kunjungan')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('institution')->label('Instansi')->columnSpanFull(),

                    TextInput::make('department')->label('Jurusan'),

                    TextInput::make('province')->label('Provinsi'),

                    Textarea::make('address')->label('Alamat')->rows(3)->columnSpanFull(),

                    TextInput::make('preferred_date')
                        ->label('Tanggal & jam kunjungan')
                        ->formatStateUsing(fn ($state, $record): string => $record?->preferred_date?->translatedFormat('l, d F Y · H:i').' WIB'),

                    TextInput::make('status')
                        ->label('Status')
                        ->formatStateUsing(fn ($state, $record): string => self::STATUSES[$record?->status] ?? '-'),

                    TextInput::make('visitors')->label('Jumlah pengunjung'),

                    TextInput::make('companions')->label('Jumlah pendamping'),
                ]),

            Section::make('Penanggung Jawab')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('contact_name')->label('Nama'),
                    TextInput::make('phone')->label('Telepon / WhatsApp'),
                    TextInput::make('email')->label('Email'),
                    TextInput::make('ktp_number')->label('No. KTP'),
                    TextInput::make('npwp')->label('NPWP'),
                ]),

            Section::make('Sumber Informasi')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('source')
                        ->label('Mengetahui dari')
                        ->formatStateUsing(fn ($state, $record): string => self::SOURCES[$record?->source] ?? '-'),

                    TextInput::make('mirota_team_name')
                        ->label('Nama Tim Mirota')
                        ->formatStateUsing(fn ($state): string => $state ?: '-'),
                ]),
        ]);
    }
}