<?php

namespace App\Filament\Resources\VisitTerms;

use App\Filament\Concerns\RequiresFeature;
use App\Filament\Resources\VisitTerms\Pages\EditVisitTerms;
use App\Filament\Resources\VisitTerms\Pages\ListVisitTerms;
use App\Models\VisitTermsPage;
use BackedEnum;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class VisitTermResource extends Resource
{
    use RequiresFeature;

    protected static function feature(): string
    {
        return 'visits';
    }

    protected static ?string $model = VisitTermsPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|UnitEnum|null $navigationGroup = 'Kunjungan Industri';

    protected static ?string $navigationLabel = 'Syarat & Ketentuan';

    protected static ?string $modelLabel = 'Syarat & Ketentuan';

    protected static ?string $pluralModelLabel = 'Syarat & Ketentuan';

    protected static ?int $navigationSort = 63;

    // Hanya ada satu dokumen: tidak bisa dibuat baru atau dihapus.
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Syarat & Ketentuan Kunjungan Industri')
                ->description('Teks ini tampil di jendela "Syarat & Ketentuan" pada formulir kunjungan di web. Perubahan langsung berlaku setelah disimpan.')
                ->columnSpanFull()
                ->schema([
                    MarkdownEditor::make('content')
                        ->label('Isi (Bahasa Indonesia)')
                        ->required()
                        ->minHeight('22rem')
                        ->helperText('Gunakan tombol daftar bernomor untuk butir ketentuan (nomor otomatis). Untuk kotak biru, awali paragraf dengan tanda ">".'),

                    MarkdownEditor::make('content_en')
                        ->label('Content (English, opsional)')
                        ->minHeight('22rem')
                        ->helperText('Jika dikosongkan, pengunjung berbahasa Inggris melihat versi Indonesia.'),
                ]),

            Section::make('Kontak PIC')
                ->columnSpanFull()
                ->schema([
                    TextInput::make('pic_phone')
                        ->label('Nomor PIC kunjungan')
                        ->maxLength(30)
                        ->helperText('Tampil merah tebal di bagian paling bawah jendela.'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('updated_at')->label('Terakhir diubah')->dateTime('d M Y, H:i'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVisitTerms::route('/'),
            'edit'  => EditVisitTerms::route('/{record}/edit'),
        ];
    }
}