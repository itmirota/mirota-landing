<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = ['type', 'name', 'email', 'phone', 'company', 'message', 'locale', 'read_at'];

    protected function casts(): array
    {
        return ['read_at' => 'datetime'];
    }
}