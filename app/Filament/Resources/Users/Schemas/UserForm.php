<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Akun')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(100),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->maxLength(150)
                        ->unique(ignoreRecord: true),

                    TextInput::make('password')
                        ->label('Kata sandi')
                        ->password()
                        ->revealable()
                        ->minLength(8)
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->helperText(fn (string $operation): ?string => $operation === 'edit'
                            ? 'Kosongkan jika tidak ingin mengganti kata sandi.'
                            : 'Minimal 8 karakter.')
                        ->columnSpanFull(),
                ]),

            Section::make('Peran & Akses')
                ->columnSpanFull()
                ->schema([
                    Select::make('role')
                        ->label('Peran')
                        ->options([
                            'superadmin' => 'Superadmin (akses penuh)',
                            'admin'      => 'Admin Fitur (akses sesuai fitur terpilih)',
                        ])
                        ->default('admin')
                        ->required()
                        ->live()
                        ->selectablePlaceholder(false)
                        ->disabled(fn (?User $record): bool => $record?->isSuperadmin() ?? false)
                        ->helperText(fn (?User $record): ?string => ($record?->isSuperadmin() ?? false)
                            ? 'Akun Superadmin tidak dapat diturunkan atau dinonaktifkan dari panel.'
                            : null),

                    CheckboxList::make('permissions')
                        ->label('Fitur yang boleh dikelola')
                        ->options(config('admin.features'))
                        ->columns(2)
                        ->bulkToggleable()
                        ->visible(fn (Get $get): bool => $get('role') === 'admin')
                        ->helperText('Lamaran Kerja berisi data pribadi pelamar; berikan hanya kepada pihak yang menanganinya (mis. HRD).'),

                    Toggle::make('is_active')
                        ->label('Akun aktif')
                        ->default(true)
                        ->hidden(fn (Get $get, $record): bool => ($record?->isSuperadmin() ?? false) || $get('role') === 'superadmin')
                        ->helperText('Akun nonaktif tidak bisa masuk ke panel admin.'),
                ]),
        ]);
    }
}