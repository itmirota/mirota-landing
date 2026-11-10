<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitInstitution extends Model
{
    protected $fillable = ['name', 'logo', 'sort_order', 'is_published'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }
}