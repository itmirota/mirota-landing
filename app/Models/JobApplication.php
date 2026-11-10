<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'job_vacancy_id', 'name', 'email', 'phone', 'cover_letter', 'cv_path', 'locale', 'status',
    ];

    public function job()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }
}