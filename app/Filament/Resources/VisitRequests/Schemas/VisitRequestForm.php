<?php

namespace App\Filament\Resources\VisitRequests\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VisitRequestForm
{
    public const TYPES = [
        'school'     => 'Sekolah',
        'university' => 'Perguruan Tinggi',
        'company'    => 'Perusahaan',
        'other'      => 'Lainnya',
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

            Section::make('Instansi')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('institution')
                        ->label('Nama instansi')
                        ->columnSpanFull(),

                    TextInput::make('institution_type')
                        ->label('Jenis')
                        ->formatStateUsing(fn ($state, $record): string => self::TYPES[$record?->institution_type] ?? '-'),

                    TextInput::make('visitors')
                        ->label('Jumlah peserta'),

                    TextInput::make('preferred_date')
                        ->label('Rencana tanggal kunjungan')
                        ->formatStateUsing(fn ($state, $record): string => $record?->preferred_date?->translatedFormat('d F Y') ?? '-'),

                    TextInput::make('status')
                        ->label('Status')
                        ->formatStateUsing(fn ($state, $record): string => self::STATUSES[$record?->status] ?? '-'),
                ]),

            Section::make('Penanggung Jawab')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('contact_name')->label('Nama'),
                    TextInput::make('phone')->label('Telepon / WhatsApp'),
                    TextInput::make('email')->label('Email')->columnSpanFull(),
                ]),

            Section::make('Pesan')
                ->columnSpanFull()
                ->schema([
                    Textarea::make('message')
                        ->label('Pesan atau kebutuhan khusus')
                        ->rows(5),
                ]),
        ]);
    }
}