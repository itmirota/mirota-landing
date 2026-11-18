<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        $markdownHelp = 'Format: ## Judul bagian, **tebal**, *miring*, - daftar, [teks](https://tautan).';

        return $schema->components([

            Section::make('Judul & Ringkasan')
                ->description('Bahasa Indonesia wajib. Versi Inggris opsional; jika kosong, web memakai versi Indonesia.')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('title')
                        ->label('Judul (ID)')
                        ->required()
                        ->maxLength(200),

                    TextInput::make('title_en')
                        ->label('Title (EN)')
                        ->maxLength(200),

                    Textarea::make('excerpt')
                        ->label('Ringkasan (ID)')
                        ->rows(3)
                        ->maxLength(300)
                        ->helperText('Tampil di kartu artikel dan sebagai deskripsi di hasil pencarian Google.'),

                    Textarea::make('excerpt_en')
                        ->label('Summary (EN)')
                        ->rows(3)
                        ->maxLength(300),

                    TextInput::make('slug')
                        ->label('Alamat halaman (slug)')
                        ->helperText('Dibuat otomatis dari judul dan tidak berubah, supaya tautan artikel tidak putus.')
                        ->disabled()
                        ->dehydrated(false)
                        ->visibleOn('edit')
                        ->columnSpanFull(),
                ]),

            Section::make('Isi Artikel')
                ->columnSpanFull()
                ->schema([
                    MarkdownEditor::make('content')
                        ->label('Isi (ID)')
                        ->required()
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('articles/content')
                        ->helperText($markdownHelp),

                    MarkdownEditor::make('content_en')
                        ->label('Content (EN)')
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('articles/content'),
                ]),

            Section::make('Sampul & Pengaturan Tayang')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    FileUpload::make('cover')
                        ->label('Gambar sampul')
                        ->image()
                        ->disk('public')
                        ->directory('articles')
                        ->visibility('public')
                        ->maxSize(2048)
                        ->helperText('JPG/PNG/WebP, maks. 2 MB. Rasio 16:10 paling pas (mis. 1600×1000 px).'),

                    Select::make('category')
                        ->label('Kategori')
                        ->options(__('article.categories', [], 'id'))
                        ->default('news')
                        ->required()
                        ->selectablePlaceholder(false),

                    Toggle::make('is_published')
                        ->label('Tayangkan')
                        ->default(false)
                        ->helperText('Matikan untuk menyimpan sebagai draf (tidak tampil di web).'),

                    DateTimePicker::make('published_at')
                        ->label('Tanggal & jadwal tayang')
                        ->seconds(false)
                        ->default(now())
                        ->helperText('Isi tanggal di masa depan untuk menjadwalkan: artikel baru tampil setelah waktu itu.'),
                ]),
        ]);
    }
}