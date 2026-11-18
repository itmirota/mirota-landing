<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Informasi Produk')
                ->description('Isi bahasa Indonesia wajib. Versi Inggris opsional; jika kosong, web memakai versi Indonesia.')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('name')
                        ->label('Nama produk (ID)')
                        ->required()
                        ->maxLength(150),

                    TextInput::make('name_en')
                        ->label('Product name (EN)')
                        ->maxLength(150),

                    Textarea::make('short_description')
                        ->label('Deskripsi singkat (ID)')
                        ->rows(2)
                        ->maxLength(300),

                    Textarea::make('short_description_en')
                        ->label('Short description (EN)')
                        ->rows(2)
                        ->maxLength(300),

                    Textarea::make('description')
                        ->label('Deskripsi lengkap (ID)')
                        ->rows(7),

                    Textarea::make('description_en')
                        ->label('Full description (EN)')
                        ->rows(7),

                    TextInput::make('slug')
                        ->label('Alamat halaman (slug)')
                        ->helperText('Dibuat otomatis dari nama dan tidak berubah, supaya tautan produk tidak putus.')
                        ->disabled()
                        ->dehydrated(false)
                        ->visibleOn('edit')
                        ->columnSpanFull(),
                ]),

            Section::make('Foto & Tampilan')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    FileUpload::make('image')
                        ->label('Foto produk')
                        ->image()
                        ->disk('public')
                        ->directory('products')
                        ->visibility('public')
                        ->maxSize(2048)
                        ->helperText('JPG/PNG/WebP, maks. 2 MB. Latar putih atau transparan (PNG) paling baik.'),

                    Toggle::make('is_featured')
                        ->label('Produk unggulan')
                        ->helperText('Tampil paling depan di beranda dan daftar produk.'),
                ]),

            Section::make('Informasi Nilai Gizi')
                ->description('Opsional. Tampil sebagai tabel di halaman detail produk.')
                ->columnSpanFull()
                ->collapsible()
                ->schema([
                    TextInput::make('nutrition.serving_size')
                        ->label('Takaran saji')
                        ->placeholder('mis. 30 g'),

                    Repeater::make('nutrition.items')
                        ->label('Komponen gizi')
                        ->schema([
                            TextInput::make('label_id')->label('Nama (ID)')->required(),
                            TextInput::make('label_en')->label('Name (EN)'),
                            TextInput::make('value')->label('Nilai')->required()->placeholder('mis. 120 kkal'),
                        ])
                        ->columns(3)
                        ->defaultItems(0)
                        ->reorderable()
                        ->addActionLabel('Tambah komponen gizi'),
                ]),
        ]);
    }
}