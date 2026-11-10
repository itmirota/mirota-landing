<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasLocalizedAttributes;

    protected $fillable = [
        'title', 'title_en', 'slug', 'excerpt', 'excerpt_en',
        'content', 'content_en', 'cover', 'category', 'is_published', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Article $article) {
            if (blank($article->slug)) {
                $base = Str::slug($article->title);
                $slug = $base;
                $i = 2;
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$i}";
                    $i++;
                }
                $article->slug = $slug;
            }
        });
    }

    /** Hanya artikel tayang, dan jadwal tayangnya sudah lewat. */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function coverUrl(): ?string
    {
        return $this->cover ? asset('storage/'.$this->cover) : null;
    }

    /** Markdown -> HTML aman (tag HTML mentah dibuang). */
    public function html(): string
    {
        return Str::markdown((string) $this->localized('content'), [
            'html_input'         => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }

    public function readingMinutes(): int
    {
        return max(1, (int) ceil(Str::wordCount(strip_tags((string) $this->localized('content'))) / 200));
    }
}