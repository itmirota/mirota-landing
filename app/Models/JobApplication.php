<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class JobApplication extends Model
{
    protected $fillable = [
        'job_vacancy_id',
        'name',
        'email',
        'phone',
        'cover_letter',
        'cv_path',
        'locale',
        'status',
    ];

    /**
     * Relasi ke lowongan pekerjaan.
     */
    public function job()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }

    /**
     * Hapus file CV ketika data lamaran dihapus.
     */
    protected static function booted(): void
    {
        static::deleting(function (JobApplication $application) {
            if ($application->cv_path) {
                Storage::delete($application->cv_path);
            }
        });
    }
}
