<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Model;

class VisitPhoto extends Model
{
    use HasLocalizedAttributes;

    protected $fillable = ['image', 'caption', 'caption_en', 'visited_at', 'sort_order', 'is_published'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean', 'visited_at' => 'date'];
    }
}