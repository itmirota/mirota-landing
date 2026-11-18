<?php

namespace App\Filament\Concerns;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;

/**
 * Batasi sebuah Resource hanya untuk pengguna yang punya izin fitur tertentu
 * (superadmin selalu lolos). Resource wajib mendefinisikan:
 *
 *     protected static function feature(): string
 *     {
 *         return 'products';
 *     }
 */
trait RequiresFeature
{
    abstract protected static function feature(): string;

    protected static function userCanManageFeature(): bool
    {
        /** @var User|null $user */
        $user = Filament::auth()->user();

        return $user !== null && $user->canManage(static::feature());
    }

    public static function canViewAny(): bool
    {
        return static::userCanManageFeature();
    }

    public static function canCreate(): bool
    {
        return static::userCanManageFeature();
    }

    public static function canEdit(Model $record): bool
    {
        return static::userCanManageFeature();
    }

    public static function canDelete(Model $record): bool
    {
        return static::userCanManageFeature();
    }

    public static function canDeleteAny(): bool
    {
        return static::userCanManageFeature();
    }
}