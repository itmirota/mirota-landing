<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Pengirim')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('type')
                        ->label('Ditujukan ke')
                        ->formatStateUsing(fn ($state, $record): string => $record?->type === 'maklon' ? 'Maklon' : 'Customer Care'),

                    TextInput::make('name')->label('Nama'),

                    TextInput::make('email')->label('Email'),

                    TextInput::make('phone')->label('Telepon'),

                    TextInput::make('company')
                        ->label('Perusahaan / brand')
                        ->columnSpanFull(),
                ]),

            Section::make('Pesan')
                ->columnSpanFull()
                ->schema([
                    Textarea::make('message')
                        ->label('Isi pesan')
                        ->rows(8),
                ]),
        ]);
    }
}