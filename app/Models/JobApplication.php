<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property int $job_vacancy_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string|null $address
 * @property string|null $cover_letter
 * @property string $cv_path
 * @property string|null $diploma_path
 * @property string|null $attachment_path
 * @property string $locale
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class JobApplication extends Model
{
    protected $fillable = [
        'job_vacancy_id', 'name', 'email', 'phone', 'address', 'cover_letter',
        'cv_path', 'diploma_path', 'attachment_path', 'locale', 'status',
    ];

    public function job()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }

    protected static function booted(): void
    {
        // Saat data lamaran dihapus, semua berkas pribadinya ikut dihapus dari disk.
        static::deleting(function (JobApplication $application) {
            foreach (['cv_path', 'diploma_path', 'attachment_path'] as $column) {
                if ($application->{$column}) {
                    Storage::delete($application->{$column});
                }
            }
        });
    }
}