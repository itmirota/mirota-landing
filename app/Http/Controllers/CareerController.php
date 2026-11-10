<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function team()
    {
        $members = TeamMember::where('is_published', true)->orderBy('sort_order')->get();

        return view('career.team', compact('members'));
    }

    public function jobs(Request $request)
    {
        $valid = array_keys(trans('career.types'));
        $type  = in_array($request->query('tipe'), $valid, true) ? $request->query('tipe') : null;

        $jobs = JobVacancy::open()
            ->when($type, fn ($q) => $q->where('type', $type))
            ->latest('published_at')
            ->get();

        return view('career.jobs', compact('jobs', 'type'));
    }

    public function show(string $slug)
    {
        $job = JobVacancy::open()->where('slug', $slug)->firstOrFail();

        return view('career.job', compact('job'));
    }

    public function apply(Request $request, string $slug)
    {
        $job = JobVacancy::open()->where('slug', $slug)->firstOrFail();

        // Honeypot untuk bot
        if ($request->filled('website')) {
            return redirect()->route('career.jobs');
        }

        $data = $request->validate([
            'name'         => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'max:150'],
            'phone'        => ['required', 'string', 'max:30'],
            'cover_letter' => ['nullable', 'string', 'max:3000'],
            'cv'           => ['required', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
        ]);

        // Disimpan di disk bawaan (storage/app/private): TIDAK bisa dibuka lewat URL.
        $path = $request->file('cv')->store('applications');

        JobApplication::create([
            'job_vacancy_id' => $job->id,
            'name'           => $data['name'],
            'email'          => $data['email'],
            'phone'          => $data['phone'],
            'cover_letter'   => $data['cover_letter'] ?? null,
            'cv_path'        => $path,
            'locale'         => app()->getLocale(),
        ]);

        return redirect()->to(route('career.job', $job->slug).'#apply')
            ->with('success', __('career.apply_success'));
    }
}