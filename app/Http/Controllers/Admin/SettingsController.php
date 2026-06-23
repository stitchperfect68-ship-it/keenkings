<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::current();
        $presets  = SiteSetting::fontPresets();
        return view('admin.pages.settings', compact('settings', 'presets'));
    }

    public function update(Request $request)
    {
        $validPresets = implode(',', array_keys(SiteSetting::fontPresets()));

        $request->validate([
            'font_preset'       => 'required|in:' . $validPresets,
            'custom_serif_name' => 'nullable|string|max:100',
            'custom_sans_name'  => 'nullable|string|max:100',
            'custom_serif_file' => 'nullable|file|mimes:woff2,woff,ttf,otf|max:5120',
            'custom_sans_file'  => 'nullable|file|mimes:woff2,woff,ttf,otf|max:5120',
        ]);

        $settings = SiteSetting::current();
        $data = ['font_preset' => $request->font_preset];

        if ($request->font_preset === 'custom') {
            $data['custom_serif_name'] = $request->custom_serif_name;
            $data['custom_sans_name']  = $request->custom_sans_name;

            if ($request->hasFile('custom_serif_file')) {
                if ($settings->custom_serif_path) {
                    Storage::disk('public')->delete($settings->custom_serif_path);
                }
                $data['custom_serif_path'] = $request->file('custom_serif_file')->store('fonts', 'public');
            }
            if ($request->hasFile('custom_sans_file')) {
                if ($settings->custom_sans_path) {
                    Storage::disk('public')->delete($settings->custom_sans_path);
                }
                $data['custom_sans_path'] = $request->file('custom_sans_file')->store('fonts', 'public');
            }
        }

        $settings->update($data);

        return back()->with('success', 'Font settings updated successfully.');
    }
}
