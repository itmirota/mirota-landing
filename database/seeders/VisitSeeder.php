<?php

namespace Database\Seeders;

use App\Models\VisitInstitution;
use App\Models\VisitVideo;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['[Contoh] SMA Negeri A', '[Contoh] SMK B', '[Contoh] Universitas C', '[Contoh] Politeknik D', '[Contoh] Institut E', '[Contoh] Akademi F'] as $i => $name) {
            VisitInstitution::updateOrCreate(['name' => $name], ['sort_order' => $i, 'is_published' => true]);
        }

        // ID video demo; ganti dengan video kunjungan industri Mirota.
        VisitVideo::updateOrCreate(['youtube_id' => 'M7lc1UVf-VE'], [
            'title' => '[Contoh] Video Kunjungan Industri', 'title_en' => '[Sample] Industrial Visit Video', 'sort_order' => 1,
        ]);
    }
}