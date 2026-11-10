<?php

namespace Database\Seeders;

use App\Models\MaklonVideo;
use App\Models\Partner;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class MaklonSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['[Contoh] PT Mitra Satu', '[Contoh] PT Mitra Dua', '[Contoh] PT Mitra Tiga', '[Contoh] PT Mitra Empat'] as $i => $name) {
            Partner::updateOrCreate(['name' => $name], ['sort_order' => $i, 'is_published' => true]);
        }

        Testimonial::updateOrCreate(['name' => '[Contoh] Nama Klien 1'], [
            'position' => 'Direktur', 'company' => '[Contoh] PT Mitra Satu',
            'quote'    => '[Contoh] Tim Mirota profesional dan responsif, kualitas produk konsisten dari batch ke batch.',
            'quote_en' => '[Sample] The Mirota team is professional and responsive, with consistent product quality batch after batch.',
            'sort_order' => 1,
        ]);

        Testimonial::updateOrCreate(['name' => '[Contoh] Nama Klien 2'], [
            'position' => 'Product Manager', 'company' => '[Contoh] PT Mitra Dua',
            'quote'    => '[Contoh] Proses pengembangan produk dari formula sampai produksi berjalan jelas dan tepat waktu.',
            'quote_en' => '[Sample] Product development from formula to production was clear and on schedule.',
            'sort_order' => 2,
        ]);

        // ID di bawah hanyalah video demo YouTube; ganti dengan video maklon Mirota.
        MaklonVideo::updateOrCreate(['youtube_id' => 'M7lc1UVf-VE'], [
            'title' => 'Video Proses Maklon', 'title_en' => '[Sample] Contract Manufacturing Video', 'sort_order' => 1,
        ]);
    }
}