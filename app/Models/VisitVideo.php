<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Model;

class VisitVideo extends Model
{
    use HasLocalizedAttributes;

    protected $fillable = ['title', 'title_en', 'youtube_id', 'sort_order', 'is_published'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }
}