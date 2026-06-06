<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialsController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();
        return view('admin.pages.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.pages.testimonials.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'quote'      => 'required|string|max:600',
            'name'       => 'required|string|max:150',
            'role'       => 'required|string|max:150',
            'avatar_url' => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer',
            'is_active'  => 'nullable|boolean',
        ]);
        $data['is_active']  = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? Testimonial::max('sort_order') + 1;
        Testimonial::create($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial added.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.pages.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'quote'      => 'required|string|max:600',
            'name'       => 'required|string|max:150',
            'role'       => 'required|string|max:150',
            'avatar_url' => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer',
            'is_active'  => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $testimonial->update($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted.');
    }
}
