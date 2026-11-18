<?php

namespace App\Filament\Resources\JobVacancies\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JobVacancyForm
{
    public static function configure(Schema $schema): Schema
    {
        $help = 'Format: ## Subjudul, **tebal**, - daftar poin.';

        return $schema->components([

            Section::make('Informasi Lowongan')
                ->description('Bahasa Indonesia wajib. Versi Inggris opsional; jika kosong, web memakai versi Indonesia.')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('title')
                        ->label('Nama posisi (ID)')
                        ->required()
                        ->maxLength(150),

                    TextInput::make('title_en')
                        ->label('Position title (EN)')
                        ->maxLength(150),

                    TextInput::make('department')
                        ->label('Departemen / bagian')
                        ->maxLength(100),

                    TextInput::make('location')
                        ->label('Lokasi')
                        ->default('Sleman, DI Yogyakarta')
                        ->maxLength(100),

                    Select::make('type')
                        ->label('Jenis')
                        ->options(__('career.types', [], 'id'))
                        ->default('full_time')
                        ->required()
                        ->selectablePlaceholder(false),

                    DatePicker::make('closing_date')
                        ->label('Batas pendaftaran')
                        ->helperText('Kosongkan jika tanpa batas. Lowongan tertutup otomatis setelah tanggal ini.'),

                    TextInput::make('slug')
                        ->label('Alamat halaman (slug)')
                        ->helperText('Dibuat otomatis dari nama posisi dan tidak berubah.')
                        ->disabled()
                        ->dehydrated(false)
                        ->visibleOn('edit')
                        ->columnSpanFull(),
                ]),

            Section::make('Deskripsi & Persyaratan')
                ->columnSpanFull()
                ->schema([
                    MarkdownEditor::make('description')
                        ->label('Deskripsi pekerjaan (ID)')
                        ->required()
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('jobs/content')
                        ->helperText($help),

                    MarkdownEditor::make('description_en')
                        ->label('Job description (EN)')
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('jobs/content'),

                    MarkdownEditor::make('requirements')
                        ->label('Persyaratan (ID)')
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('jobs/content'),

                    MarkdownEditor::make('requirements_en')
                        ->label('Requirements (EN)')
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('jobs/content'),
                ]),

            Section::make('Pengaturan Tayang')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    Toggle::make('is_published')
                        ->label('Tayangkan')
                        ->default(true)
                        ->helperText('Matikan untuk menyembunyikan lowongan dari web tanpa menghapusnya.'),

                    DateTimePicker::make('published_at')
                        ->label('Tanggal tayang')
                        ->seconds(false)
                        ->default(now())
                        ->helperText('Tanggal di masa depan menjadwalkan lowongan tampil nanti.'),
                ]),
        ]);
    }
}