<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;

/**
 * Pencarian kolom tanggal berdasarkan teks yang diketik orang, bukan format database.
 *
 * Contoh yang dikenali: "25 Nov", "25 november 2026", "25/11", "25-11-2026",
 * "2026-11-25", "nov", "november 2026", "2026", dan "25" (tanggal 25).
 * Nama bulan boleh bahasa Indonesia maupun Inggris, lengkap atau singkatan (min. 3 huruf).
 */
class DateSearch
{
    /** @var array<int, array<int, string>> */
    protected const MONTHS = [
        1 => ['januari', 'january'],
        2 => ['februari', 'february'],
        3 => ['maret', 'march'],
        4 => ['april'],
        5 => ['mei', 'may'],
        6 => ['juni', 'june'],
        7 => ['juli', 'july'],
        8 => ['agustus', 'august'],
        9 => ['september'],
        10 => ['oktober', 'october'],
        11 => ['november', 'nopember'],
        12 => ['desember', 'december'],
    ];

    /**
     * Terapkan pencarian ke query. Kalau teks bukan tanggal, kolom ini tidak cocok dengan apa pun.
     */
    public static function apply(Builder $query, string $column, string $search): Builder
    {
        $parts = self::parse($search);

        if ($parts === null) {
            return $query->whereRaw('1 = 0');
        }

        if ($parts['year'] !== null) {
            $query->whereYear($column, $parts['year']);
        }

        if ($parts['month'] !== null) {
            $query->whereMonth($column, $parts['month']);
        }

        if ($parts['day'] !== null) {
            $query->whereDay($column, $parts['day']);
        }

        return $query;
    }

    /**
     * @return array{day: ?int, month: ?int, year: ?int}|null
     */
    public static function parse(string $search): ?array
    {
        $text = mb_strtolower(trim($search));
        $text = rtrim($text, ',.');

        if ($text === '') {
            return null;
        }

        // 2026-11-25
        if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $text, $m)) {
            return self::make((int) $m[3], (int) $m[2], (int) $m[1]);
        }

        // 25/11, 25-11, 25.11.2026
        if (preg_match('/^(\d{1,2})[\/\-.](\d{1,2})(?:[\/\-.](\d{4}))?$/', $text, $m)) {
            return self::make((int) $m[1], (int) $m[2], isset($m[3]) ? (int) $m[3] : null);
        }

        // 25 nov, 25 november 2026
        if (preg_match('/^(\d{1,2})\s+([a-z]+)(?:\s+(\d{4}))?$/', $text, $m)) {
            $month = self::monthFromName($m[2]);

            return $month === null ? null : self::make((int) $m[1], $month, isset($m[3]) ? (int) $m[3] : null);
        }

        // nov 2026
        if (preg_match('/^([a-z]+)\s+(\d{4})$/', $text, $m)) {
            $month = self::monthFromName($m[1]);

            return $month === null ? null : self::make(null, $month, (int) $m[2]);
        }

        // 2026
        if (preg_match('/^\d{4}$/', $text)) {
            return self::make(null, null, (int) $text);
        }

        // 25
        if (preg_match('/^\d{1,2}$/', $text)) {
            return self::make((int) $text, null, null);
        }

        // nov
        if (preg_match('/^[a-z]+$/', $text)) {
            $month = self::monthFromName($text);

            return $month === null ? null : self::make(null, $month, null);
        }

        return null;
    }

    protected static function monthFromName(string $name): ?int
    {
        if (mb_strlen($name) < 3) {
            return null;
        }

        foreach (self::MONTHS as $number => $names) {
            foreach ($names as $full) {
                if (str_starts_with($full, $name)) {
                    return $number;
                }
            }
        }

        return null;
    }

    /**
     * @return array{day: ?int, month: ?int, year: ?int}|null
     */
    protected static function make(?int $day, ?int $month, ?int $year): ?array
    {
        if ($day !== null && ($day < 1 || $day > 31)) {
            return null;
        }

        if ($month !== null && ($month < 1 || $month > 12)) {
            return null;
        }

        return ['day' => $day, 'month' => $month, 'year' => $year];
    }
}