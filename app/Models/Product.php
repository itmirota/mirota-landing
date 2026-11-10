<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasLocalizedAttributes;

    protected $fillable = [
        'name', 'name_en', 'slug',
        'short_description', 'short_description_en',
        'description', 'description_en',
        'nutrition', 'image', 'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'nutrition'   => 'array',
            'is_featured' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (blank($product->slug)) {
                $base = Str::slug($product->name);
                $slug = $base;
                $i = 2;

                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$i}";
                    $i++;
                }

                $product->slug = $slug;
            }
        });
    }
}
