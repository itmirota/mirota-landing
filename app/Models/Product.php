<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'image',
        'is_featured',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}