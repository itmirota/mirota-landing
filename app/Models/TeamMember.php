<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasLocalizedAttributes;

    protected $fillable = ['name', 'position', 'position_en', 'photo', 'sort_order', 'is_published'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }
}