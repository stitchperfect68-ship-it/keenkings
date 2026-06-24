<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutContent;
use App\Models\Stat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $about = AboutContent::getSingleton();
        $stats = Stat::orderBy('sort_order')->get();
        return view('admin.pages.about', compact('about', 'stats'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'eyebrow'          => 'required|string|max:200',
            'heading'          => 'required|string|max:300',
            'lead_text'        => 'required|string|max:1000',
            'body_text'        => 'required|string|max:2000',
            'quote'            => 'nullable|string|max:500',
            'skills'           => 'nullable|string',
            'main_image_url'   => 'nullable|url|max:500',
            'main_image_file'  => 'nullable|image|max:8192',
            'accent_image_url' => 'nullable|url|max:500',
            'accent_image_file'=> 'nullable|image|max:8192',
            'founded_year'     => 'required|string|max:4',
            'pillar_1'         => 'required|string|max:50',
            'pillar_2'         => 'required|string|max:50',
            'pillar_3'         => 'required|string|max:50',
        ]);

        // Parse skills textarea (one per line) into array
        if (isset($data['skills'])) {
            $data['skills'] = array_values(array_filter(
                array_map('trim', explode("\n", $data['skills']))
            ));
        }

        $about = AboutContent::getSingleton();

        $disk = config('filesystems.media_disk');

        if ($request->hasFile('main_image_file')) {
            if ($about->main_image_path) Storage::disk($disk)->delete($about->main_image_path);
            $path = $request->file('main_image_file')->store('about', $disk);
            $data['main_image_path'] = $path;
            $data['main_image_url']  = Storage::disk($disk)->url($path);
        }

        if ($request->hasFile('accent_image_file')) {
            if ($about->accent_image_path) Storage::disk($disk)->delete($about->accent_image_path);
            $path = $request->file('accent_image_file')->store('about', $disk);
            $data['accent_image_path'] = $path;
            $data['accent_image_url']  = Storage::disk($disk)->url($path);
        }

        // Remove file fields from data before update
        unset($data['main_image_file'], $data['accent_image_file']);

        $about->update($data);
        return redirect()->route('admin.about.index')->with('success', 'About content updated successfully.');
    }

    // ── Stats CRUD ──
    public function storeStat(Request $request)
    {
        $data = $request->validate(['value' => 'required|string|max:20', 'label' => 'required|string|max:50', 'sort_order' => 'nullable|integer']);
        $data['sort_order'] = $data['sort_order'] ?? Stat::max('sort_order') + 1;
        Stat::create($data);
        return back()->with('success', 'Stat added.');
    }

    public function updateStat(Request $request, Stat $stat)
    {
        $stat->update($request->validate(['value' => 'required|string|max:20', 'label' => 'required|string|max:50', 'is_active' => 'nullable|boolean']));
        $stat->is_active = $request->boolean('is_active');
        $stat->save();
        return back()->with('success', 'Stat updated.');
    }

    public function destroyStat(Stat $stat)
    {
        $stat->delete();
        return back()->with('success', 'Stat deleted.');
    }
}
