<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JobVacancy extends Model
{
    use HasLocalizedAttributes;

    protected $fillable = [
        'title', 'title_en', 'slug', 'department', 'location', 'type',
        'description', 'description_en', 'requirements', 'requirements_en',
        'closing_date', 'is_published', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'closing_date' => 'date',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (JobVacancy $job) {
            if (blank($job->slug)) {
                $base = Str::slug($job->title);
                $slug = $base;
                $i = 2;
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$i}";
                    $i++;
                }
                $job->slug = $slug;
            }
        });
    }

    /** Lowongan tayang dan belum melewati batas pendaftaran. */
    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()))
            ->where(fn ($q) => $q->whereNull('closing_date')->orWhereDate('closing_date', '>=', today()));
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function daysLeft(): ?int
    {
        if (! $this->closing_date) {
            return null;
        }

        $closing = \Illuminate\Support\Carbon::parse($this->closing_date)->startOfDay();

        return max(0, (int) today()->diffInDays($closing, false));
    }

    /** Markdown -> HTML aman. */
    public function html(string $attribute): string
    {
        return Str::markdown((string) $this->localized($attribute), [
            'html_input'         => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }
}