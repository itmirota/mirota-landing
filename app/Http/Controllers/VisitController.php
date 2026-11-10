<?php

namespace App\Http\Controllers;

use App\Models\VisitInstitution;
use App\Models\VisitPhoto;
use App\Models\VisitRequest;
use App\Models\VisitVideo;
use Illuminate\Http\Request;

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

        $data = $request->validate([
            'institution'      => ['required', 'string', 'max:150'],
            'institution_type' => ['required', 'in:school,university,company,other'],
            'contact_name'     => ['required', 'string', 'max:100'],
            'email'            => ['required', 'email', 'max:150'],
            'phone'            => ['required', 'string', 'max:30'],
            'visitors'         => ['required', 'integer', 'min:1', 'max:500'],
            'preferred_date'   => ['required', 'date', 'after:today'],
            'message'          => ['nullable', 'string', 'max:2000'],
        ]);

        VisitRequest::create($data + ['locale' => app()->getLocale()]);

        return redirect()->to(route('visit').'#form')->with('success', __('visit.success'));
    }
}