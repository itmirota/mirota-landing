<?php

namespace App\Support;

class YouTube
{
    /** Ambil ID video 11 karakter dari tautan YouTube (watch, youtu.be, embed, shorts) atau ID polos. */
    public static function id(?string $input): ?string
    {
        $input = trim((string) $input);

        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $input)) {
            return $input;
        }

        if (preg_match('~(?:youtu\.be/|v=|/embed/|/shorts/)([A-Za-z0-9_-]{11})~', $input, $m)) {
            return $m[1];
        }

        return null;
    }
}