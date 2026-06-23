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
        $settings      = SiteSetting::current();
        $headingFonts  = SiteSetting::headingFonts();
        $bodyFonts     = SiteSetting::bodyFonts();
        return view('admin.pages.settings', compact('settings', 'headingFonts', 'bodyFonts'));
    }

    public function update(Request $request)
    {
        $allHeading = collect(SiteSetting::headingFonts())->flatten()->toArray();
        $allBody    = collect(SiteSetting::bodyFonts())->flatten()->toArray();

        $request->validate([
            'font_preset'       => 'required|in:google,custom',
            'heading_font'      => 'required_if:font_preset,google|nullable|in:' . implode(',', $allHeading),
            'body_font'         => 'required_if:font_preset,google|nullable|in:' . implode(',', $allBody),
            'custom_serif_name' => 'nullable|string|max:100',
            'custom_sans_name'  => 'nullable|string|max:100',
            'custom_serif_file' => 'nullable|file|mimes:woff2,woff,ttf,otf|max:5120',
            'custom_sans_file'  => 'nullable|file|mimes:woff2,woff,ttf,otf|max:5120',
        ]);

        $settings = SiteSetting::current();

        if ($request->font_preset === 'custom') {
            $data = [
                'font_preset'       => 'custom',
                'custom_serif_name' => $request->custom_serif_name,
                'custom_sans_name'  => $request->custom_sans_name,
            ];
            if ($request->hasFile('custom_serif_file')) {
                if ($settings->custom_serif_path) Storage::disk('public')->delete($settings->custom_serif_path);
                $data['custom_serif_path'] = $request->file('custom_serif_file')->store('fonts', 'public');
            }
            if ($request->hasFile('custom_sans_file')) {
                if ($settings->custom_sans_path) Storage::disk('public')->delete($settings->custom_sans_path);
                $data['custom_sans_path'] = $request->file('custom_sans_file')->store('fonts', 'public');
            }
        } else {
            $data = [
                'font_preset'  => 'google',
                'heading_font' => $request->heading_font,
                'body_font'    => $request->body_font,
            ];
        }

        $settings->update($data);

        return back()->with('success', 'Font settings updated successfully.');
    }
}
