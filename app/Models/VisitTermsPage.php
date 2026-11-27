<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string|null $content
 * @property string|null $content_en
 * @property string|null $pic_phone
 */
class VisitTermsPage extends Model
{
    use HasLocalizedAttributes;

    protected $fillable = ['content', 'content_en', 'pic_phone'];

    /** Satu-satunya baris; dibuat otomatis (terisi dari teks bawaan) jika belum ada. */
    public static function instance(): static
    {
        return static::first() ?? static::create(static::defaults());
    }

    public static function defaults(): array
    {
        $build = function (string $locale): string {
            $list = collect(trans('visit.terms', [], $locale))
                ->map(fn ($text) => '1. '.$text)
                ->implode("\n");

            return $list."\n\n> ".trans('visit.terms_note', [], $locale);
        };

        return [
            'content'    => $build('id'),
            'content_en' => $build('en'),
            'pic_phone'  => trans('visit.terms_pic_number', [], 'id'),
        ];
    }
}