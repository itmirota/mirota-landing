<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        $cv         = __('career.job.cv_name');
        $diploma    = __('career.job.diploma_name');
        $attachment = __('career.job.attachment_name');

        $validator = Validator::make(
            $request->all(),
            [
                'name'       => ['required', 'string', 'max:100'],
                'address'    => ['required', 'string', 'max:500'],
                'email'      => ['required', 'email', 'max:150'],
                'phone'      => ['required', 'string', 'max:30'],
                'cv'         => ['required', 'file', 'mimes:pdf', 'max:2048'],
                'diploma'    => ['required', 'file', 'mimes:pdf', 'max:2048'],
                'attachment' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            ],
            [
                'cv.required'         => __('career.job.err_required', ['name' => $cv]),
                'cv.max'              => __('career.job.err_max',      ['name' => $cv]),
                'cv.uploaded'         => __('career.job.err_upload',   ['name' => $cv]),
                'cv.mimes'            => __('career.job.err_type',     ['name' => $cv]),

                'diploma.required'    => __('career.job.err_required', ['name' => $diploma]),
                'diploma.max'         => __('career.job.err_max',      ['name' => $diploma]),
                'diploma.uploaded'    => __('career.job.err_upload',   ['name' => $diploma]),
                'diploma.mimes'       => __('career.job.err_type',     ['name' => $diploma]),

                'attachment.max'      => __('career.job.err_max',      ['name' => $attachment]),
                'attachment.uploaded' => __('career.job.err_upload',   ['name' => $attachment]),
                'attachment.mimes'    => __('career.job.err_type',     ['name' => $attachment]),
            ],
            [
                'name'    => __('career.job.full_name'),
                'address' => __('career.job.address'),
                'email'   => __('career.job.email'),
                'phone'   => __('career.job.whatsapp'),
            ]
        );

        // Gagal: kembali langsung ke formulir (bukan ke puncak halaman).
        if ($validator->fails()) {
            return redirect()->to(route('career.job', $job->slug).'#apply')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        // Semua berkas disimpan di disk bawaan (storage/app/private): TIDAK bisa dibuka lewat URL.
        $cvPath         = $request->file('cv')->store('applications');
        $diplomaPath    = $request->file('diploma')->store('applications/diploma');
        $attachmentPath = $request->file('attachment')?->store('applications/attachments');

        JobApplication::create([
            'job_vacancy_id'  => $job->id,
            'name'            => $data['name'],
            'address'         => $data['address'],
            'email'           => $data['email'],
            'phone'           => $data['phone'],
            'cv_path'         => $cvPath,
            'diploma_path'    => $diplomaPath,
            'attachment_path' => $attachmentPath,
            'locale'          => app()->getLocale(),
        ]);

        return redirect()->to(route('career.job', $job->slug).'#apply')
            ->with('success', __('career.apply_success'));
    }
}