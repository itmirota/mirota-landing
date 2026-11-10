<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasLocalizedAttributes;

    protected $fillable = ['name', 'position', 'company', 'quote', 'quote_en', 'photo', 'sort_order', 'is_published'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }
}