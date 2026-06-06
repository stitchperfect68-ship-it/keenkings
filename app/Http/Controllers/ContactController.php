<?php

namespace App\Http\Controllers;

use App\Models\ContactEnquiry;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'phone'   => 'nullable|string|max:20',
            'service' => 'nullable|string|max:100',
            'message' => 'required|string|max:2000',
        ]);

        ContactEnquiry::create($validated);

        return redirect()->route('home')
            ->with('success', 'Thank you, ' . $validated['name'] . '! We will be in touch shortly.');
    }
}
