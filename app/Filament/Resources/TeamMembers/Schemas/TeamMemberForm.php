<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeamMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Anggota Tim')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(100)
                        ->columnSpanFull(),

                    TextInput::make('position')
                        ->label('Jabatan (ID)')
                        ->required()
                        ->maxLength(100),

                    TextInput::make('position_en')
                        ->label('Position (EN)')
                        ->maxLength(100),

                    FileUpload::make('photo')
                        ->label('Foto')
                        ->image()
                        ->disk('public')
                        ->directory('team')
                        ->visibility('public')
                        ->maxSize(2048)
                        ->helperText('Rasio 4:5 (potret) paling pas. Pastikan orangnya sudah menyetujui fotonya ditampilkan.')
                        ->columnSpanFull(),

                    Toggle::make('is_published')
                        ->label('Tampilkan di web')
                        ->default(true),

                    TextInput::make('sort_order')
                        ->label('Urutan')
                        ->numeric()
                        ->default(0)
                        ->helperText('Angka kecil tampil lebih dulu. Urutan juga bisa digeser di daftar.'),
                ]),
        ]);
    }
}