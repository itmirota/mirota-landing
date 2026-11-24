<?php

namespace App\Support;

/**
 * Sumber data pengunjung website untuk dasbor admin.
 *
 * PENTING: saat ini isinya DATA CONTOH, karena belum ada tabel yang mencatat
 * pengunjung. Ganti isi method monthly() dengan query ke tabel pencatat
 * pengunjung nanti, semua widget dasbor otomatis ikut.
 */
class VisitorData
{
    /**
     * Jumlah pengunjung per bulan (indeks 0 = Januari) untuk satu tahun.
     *
     * @return array<int, int>
     */
    public static function monthly(int $year): array
    {
        return [1200, 3100, 4800, 6200, 8500, 7200, 6100, 7900, 9400, 8100, 8900, 9800];
    }

    /**
     * @return array<int, string>
     */
    public static function monthNames(): array
    {
        return [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
        ];
    }

    /**
     * Daftar tahun untuk filter, tahun berjalan di urutan pertama.
     *
     * @return array<int, int>
     */
    public static function years(): array
    {
        $current = (int) now()->year;

        return [$current, $current - 1, $current - 2];
    }

    public static function total(int $year): int
    {
        return array_sum(static::monthly($year));
    }

    public static function thisMonth(): int
    {
        return static::monthly((int) now()->year)[(int) now()->month - 1];
    }

    public static function today(): int
    {
        return intdiv(static::thisMonth(), max(1, (int) now()->daysInMonth));
    }

    public static function format(int $number): string
    {
        return number_format($number, 0, ',', '.');
    }
}
