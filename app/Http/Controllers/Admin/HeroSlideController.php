<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->get();
        return view('admin.pages.hero.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.pages.hero.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image_url'  => 'required_without:image_file|nullable|url|max:500',
            'image_file' => 'nullable|image|max:8192',
            'heading'    => 'nullable|string|max:200',
            'subheading' => 'nullable|string|max:300',
            'sort_order' => 'nullable|integer',
            'is_active'  => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('hero', 'public');
            $data['image_path'] = $path;
            $data['image_url']  = Storage::url($path);
        }

        $data['is_active']  = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? HeroSlide::max('sort_order') + 1;

        HeroSlide::create($data);
        return redirect()->route('admin.hero.index')->with('success', 'Hero slide added.');
    }

    public function edit(HeroSlide $hero)
    {
        return view('admin.pages.hero.form', ['slide' => $hero]);
    }

    public function update(Request $request, HeroSlide $hero)
    {
        $data = $request->validate([
            'image_url'  => 'nullable|url|max:500',
            'image_file' => 'nullable|image|max:8192',
            'heading'    => 'nullable|string|max:200',
            'subheading' => 'nullable|string|max:300',
            'sort_order' => 'nullable|integer',
            'is_active'  => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_file')) {
            if ($hero->image_path) Storage::disk('public')->delete($hero->image_path);
            $path = $request->file('image_file')->store('hero', 'public');
            $data['image_path'] = $path;
            $data['image_url']  = Storage::url($path);
        }

        $data['is_active'] = $request->boolean('is_active');
        $hero->update($data);
        return redirect()->route('admin.hero.index')->with('success', 'Hero slide updated.');
    }

    public function destroy(HeroSlide $hero)
    {
        if ($hero->image_path) Storage::disk('public')->delete($hero->image_path);
        $hero->delete();
        return redirect()->route('admin.hero.index')->with('success', 'Slide deleted.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            HeroSlide::where('id', $id)->update(['sort_order' => $index]);
        }
        return response()->json(['success' => true]);
    }
}
