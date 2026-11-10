<?php

namespace App\Http\Controllers;

use App\Models\MaklonVideo;
use App\Models\Partner;
use App\Models\Testimonial;

class MaklonController extends Controller
{
    public function index()
    {
        return view('maklon', [
            'partners'     => Partner::where('is_published', true)->orderBy('sort_order')->get(),
            'videos'       => MaklonVideo::where('is_published', true)->orderBy('sort_order')->get(),
            'testimonials' => Testimonial::where('is_published', true)->orderBy('sort_order')->get(),
        ]);
    }
}