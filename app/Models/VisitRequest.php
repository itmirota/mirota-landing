<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VisitRequest extends Model
{
    protected $fillable = [
        'institution', 'contact_name', 'npwp', 'ktp_number', 'email', 'phone',
        'source', 'mirota_team_name', 'province', 'address', 'department',
        'visitors', 'companions', 'preferred_date',
        'ktp_photo_path', 'letter_path',
        'institution_type', 'message', 'locale', 'status',
    ];

    protected function casts(): array
    {
        return [
            'preferred_date' => 'datetime',
            'npwp'           => 'encrypted',
            'ktp_number'     => 'encrypted',
        ];
    }

    protected static function booted(): void
    {
        // Saat pengajuan dihapus, berkas pribadinya ikut dihapus dari disk.
        static::deleting(function (VisitRequest $request) {
            foreach (['ktp_photo_path', 'letter_path'] as $column) {
                if ($request->{$column}) {
                    Storage::delete($request->{$column});
                }
            }
        });
    }
}