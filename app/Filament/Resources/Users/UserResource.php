<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Users Management';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Pengguna';

    protected static ?string $pluralModelLabel = 'Users Management';

    protected static ?int $navigationSort = 12;

    protected static function actor(): ?User
    {
        /** @var User|null $user */
        $user = Filament::auth()->user();

        return $user;
    }

    // Hanya Superadmin yang boleh mengelola pengguna.
    public static function canViewAny(): bool
    {
        return static::actor()?->isSuperadmin() ?? false;
    }

    public static function canCreate(): bool
    {
        return static::actor()?->isSuperadmin() ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return static::actor()?->isSuperadmin() ?? false;
    }

    // Tidak boleh menghapus akun sendiri.
    public static function canDelete(Model $record): bool
    {
        $actor = static::actor();

        return $actor !== null
            && $actor->isSuperadmin()
            && $actor->getKey() !== $record->getKey();
    }

    // Tanpa hapus massal, supaya aman.
    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}