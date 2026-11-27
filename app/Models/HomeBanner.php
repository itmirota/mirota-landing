<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $image
 * @property string|null $image_mobile
 * @property string|null $alt
 * @property string|null $link
 * @property int $sort_order
 * @property bool $is_published
 */
class HomeBanner extends Model
{
    protected $fillable = ['image', 'image_mobile', 'alt', 'link', 'sort_order', 'is_published'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }
}