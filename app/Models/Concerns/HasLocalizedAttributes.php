<?php

namespace App\Models\Concerns;

trait HasLocalizedAttributes
{
    /** Ambil atribut sesuai bahasa aktif; jika terjemahan kosong, pakai bahasa Indonesia. */
    public function localized(string $attribute): mixed
    {
        $locale = app()->getLocale();

        if ($locale !== 'id') {
            $value = $this->getAttribute("{$attribute}_{$locale}");
            if (filled($value)) {
                return $value;
            }
        }

        return $this->getAttribute($attribute);
    }
}