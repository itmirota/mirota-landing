<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitRequest extends Model
{
    protected $fillable = [
        'institution', 'institution_type', 'contact_name', 'email', 'phone',
        'visitors', 'preferred_date', 'message', 'locale', 'status',
    ];

    protected function casts(): array
    {
        return ['preferred_date' => 'date'];
    }
}