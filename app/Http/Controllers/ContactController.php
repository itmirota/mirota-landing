<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        // Honeypot: kolom tersembunyi ini hanya diisi bot.
        if ($request->filled('website')) {
            return redirect()->route('contact');
        }

        $data = $request->validate([
            'type'    => ['required', 'in:customer_care,maklon'],
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:150'],
            'phone'   => ['nullable', 'string', 'max:30'],
            'company' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        ContactMessage::create($data + ['locale' => app()->getLocale()]);

        return redirect()->route('contact')->with('success', __('contact.success'));
    }
}