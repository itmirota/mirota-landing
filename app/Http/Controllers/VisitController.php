<?php

namespace App\Http\Controllers;

use App\Models\VisitInstitution;
use App\Models\VisitPhoto;
use App\Models\VisitRequest;
use App\Models\VisitVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class VisitController extends Controller
{
    public function index()
    {
        return view('visit', [
            'photos'       => VisitPhoto::where('is_published', true)->orderBy('sort_order')->latest('visited_at')->get(),
            'videos'       => VisitVideo::where('is_published', true)->orderBy('sort_order')->get(),
            'institutions' => VisitInstitution::where('is_published', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request)
    {
        // Honeypot: kolom tersembunyi ini hanya diisi bot.
        if ($request->filled('website')) {
            return redirect()->route('visit');
        }

        $rules = [
            'institution'      => ['required', 'string', 'max:150'],
            'contact_name'     => ['required', 'string', 'max:100'],
            'ktp_number'       => ['required_without:npwp', 'nullable', 'digits:16'],
            'npwp'             => ['nullable', 'string', 'max:30', function ($attribute, $value, $fail) {
                $digits = preg_replace('/\D/', '', (string) $value);

                if (! in_array(strlen($digits), [15, 16], true)) {
                    $fail(__('visit.err_npwp_format'));
                }
            }],
            'email'            => ['required', 'email', 'max:150'],
            'phone'            => ['required', 'string', 'max:30'],
            'source'           => ['required', Rule::in(['ad', 'website', 'referral', 'mirota_team'])],
            'mirota_team_name' => ['required_if:source,mirota_team', 'nullable', 'string', 'max:100'],
            'province'         => ['required', Rule::in(config('provinces'))],
            'address'          => ['required', 'string', 'max:500'],
            'preferred_date'   => ['required', 'date', 'after_or_equal:tomorrow', function ($attribute, $value, $fail) {
                $at = Carbon::parse($value);

                if ($at->isWeekend()) {
                    $fail(__('visit.err_weekday'));

                    return;
                }

                $time = $at->format('H:i');
                $inSession = ($time >= '09:00' && $time <= '12:00') || ($time >= '13:00' && $time <= '15:00');

                if (! $inSession) {
                    $fail(__('visit.err_session'));
                }
            }],
            'department'       => ['nullable', 'string', 'max:100'],
            'visitors'         => ['required', 'integer', 'min:1', 'max:500'],
            'companions'       => ['nullable', 'integer', 'min:0', 'max:100'],
            'ktp_photo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'letter'           => ['required', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:3072'],
            'agree'            => ['accepted'],
        ];

        $ktpName    = __('visit.ktp_photo');
        $letterName = __('visit.letter');

        $messages = [
            'ktp_number.digits'            => __('visit.err_ktp_digits'),
            'ktp_number.required_without'  => __('visit.err_id_required'),
            'preferred_date.after_or_equal'=> __('visit.err_date_future'),
            'agree.accepted'               => __('visit.err_agree'),

            'ktp_photo.max'      => __('visit.err_file_max',    ['name' => $ktpName, 'max' => '2 MB']),
            'ktp_photo.uploaded' => __('visit.err_file_upload', ['name' => $ktpName, 'max' => '2 MB']),
            'ktp_photo.image'    => __('visit.err_file_type',   ['name' => $ktpName, 'types' => 'JPG, PNG']),
            'ktp_photo.mimes'    => __('visit.err_file_type',   ['name' => $ktpName, 'types' => 'JPG, PNG']),

            'letter.required'    => __('visit.err_letter_required'),
            'letter.max'         => __('visit.err_file_max',    ['name' => $letterName, 'max' => '3 MB']),
            'letter.uploaded'    => __('visit.err_file_upload', ['name' => $letterName, 'max' => '3 MB']),
            'letter.mimes'       => __('visit.err_file_type',   ['name' => $letterName, 'types' => 'PDF, DOC, DOCX, JPG, PNG']),
        ];

        $attributes = [
            'institution'      => __('visit.institution'),
            'contact_name'     => __('visit.contact_name'),
            'ktp_number'       => __('visit.ktp_number'),
            'npwp'             => __('visit.npwp'),
            'email'            => 'Email',
            'phone'            => __('visit.phone'),
            'source'           => __('visit.source_label'),
            'mirota_team_name' => __('visit.mirota_team_name'),
            'province'         => __('visit.province_label'),
            'address'          => __('visit.address'),
            'preferred_date'   => __('visit.visit_at'),
            'department'       => __('visit.department'),
            'visitors'         => __('visit.visitors'),
            'companions'       => __('visit.companions'),
            'ktp_photo'        => $ktpName,
            'letter'           => $letterName,
            'agree'            => __('visit.terms_button'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        // Gagal: kembali langsung ke formulir (bukan ke puncak halaman).
        if ($validator->fails()) {
            return redirect()->to(route('visit').'#form')->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Disimpan di disk bawaan (storage/app/private): tidak bisa dibuka lewat URL.
        $ktpPath    = $request->file('ktp_photo')?->store('visit-requests/ktp');
        $letterPath = $request->file('letter')->store('visit-requests/letters');

        VisitRequest::create([
            'institution'      => $data['institution'],
            'contact_name'     => $data['contact_name'],
            'ktp_number'       => $data['ktp_number'] ?? null,
            'npwp'             => $data['npwp'] ?? null,
            'email'            => $data['email'],
            'phone'            => $data['phone'],
            'source'           => $data['source'],
            'mirota_team_name' => $data['source'] === 'mirota_team' ? ($data['mirota_team_name'] ?? null) : null,
            'province'         => $data['province'],
            'address'          => $data['address'],
            'department'       => $data['department'] ?? null,
            'visitors'         => $data['visitors'],
            'companions'       => $data['companions'] ?? 0,
            'preferred_date'   => $data['preferred_date'],
            'ktp_photo_path'   => $ktpPath,
            'letter_path'      => $letterPath,
            'locale'           => app()->getLocale(),
        ]);

        return redirect()->to(route('visit').'#form')->with('success', __('visit.success'));
    }
}