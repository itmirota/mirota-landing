<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            ['news', '[Contoh] Mirota KSM Hadirkan Inovasi Produk Terbaru', '[Sample] Mirota KSM Introduces Its Latest Product Innovation'],
            ['tips', '[Contoh] Tips Memilih Susu Bubuk yang Tepat untuk Keluarga', '[Sample] Tips for Choosing the Right Milk Powder for Your Family'],
            ['company', '[Contoh] Kunjungan Industri ke Pabrik Mirota KSM', '[Sample] Industrial Visit to the Mirota KSM Factory'],
            ['tips', '[Contoh] Pentingnya Nutrisi Seimbang untuk Anak', '[Sample] Why Balanced Nutrition Matters for Children'],
        ];

        foreach ($samples as $i => [$cat, $id, $en]) {
            Article::updateOrCreate(['title' => $id], [
                'title_en'     => $en,
                'excerpt'      => '[Contoh] Ringkasan singkat artikel. Ganti dengan ringkasan asli yang menarik pembaca untuk membuka artikel.',
                'excerpt_en'   => '[Sample] A short summary of the article. Replace with a real summary that invites readers to open it.',
                'content'      => "## Pendahuluan\n\n[Contoh] Ini adalah isi artikel contoh. Tulis konten asli di sini.\n\n## Poin Penting\n\n- Poin pertama\n- Poin kedua\n- Poin ketiga\n\nParagraf penutup artikel contoh.",
                'content_en'   => "## Introduction\n\n[Sample] This is sample article content. Write the real content here.\n\n## Key Points\n\n- First point\n- Second point\n- Third point\n\nClosing paragraph of the sample article.",
                'category'     => $cat,
                'is_published' => true,
                'published_at' => now()->subDays(($i + 1) * 3),
            ]);
        }
    }
}