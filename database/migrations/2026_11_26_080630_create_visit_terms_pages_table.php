<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visit_terms_pages', function (Blueprint $table) {
            $table->id();
            $table->longText('content')->nullable();     // Markdown (ID)
            $table->longText('content_en')->nullable();  // Markdown (EN)
            $table->string('pic_phone', 30)->nullable();
            $table->timestamps();
        });

        // Pindahkan isi tabel lama (baris per butir) menjadi satu dokumen Markdown.
        if (Schema::hasTable('visit_terms')) {
            $rows = DB::table('visit_terms')->where('is_published', true)->orderBy('sort_order')->get();

            if ($rows->isNotEmpty()) {
                $build = function (string $column) use ($rows): string {
                    $pick = fn ($r) => trim((string) (filled($r->{$column}) ? $r->{$column} : $r->text));

                    $list = $rows->where('type', 'term')
                        ->map(fn ($r) => '1. '.str_replace(["\r\n", "\n"], ' ', $pick($r)))
                        ->implode("\n");

                    $notes = $rows->where('type', 'note')
                        ->map(fn ($r) => '> '.str_replace(["\r\n", "\n"], "\n> ", $pick($r)))
                        ->implode("\n\n");

                    return trim($list."\n\n".$notes);
                };

                $hasEnglish = $rows->filter(fn ($r) => filled($r->text_en))->isNotEmpty();
                $pic = $rows->firstWhere('type', 'pic');

                DB::table('visit_terms_pages')->insert([
                    'content'    => $build('text'),
                    'content_en' => $hasEnglish ? $build('text_en') : null,
                    'pic_phone'  => $pic ? mb_substr(preg_replace('/^[^\d+]*/', '', $pic->text), 0, 30) : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            Schema::drop('visit_terms');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_terms_pages');
    }
};