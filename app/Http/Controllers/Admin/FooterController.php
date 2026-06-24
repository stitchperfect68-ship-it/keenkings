<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSetting;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        $settings    = PageSetting::current();
        $socialLinks = SocialLink::orderBy('sort_order')->get();
        return view('admin.pages.footer', compact('settings', 'socialLinks'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'footer_description' => 'nullable|string|max:500',
            'footer_copyright'   => 'nullable|string|max:200',
        ]);

        PageSetting::current()->update($request->only(['footer_description', 'footer_copyright']));

        return back()->with('success', 'Footer settings updated.');
    }

    public function storeSocialLink(Request $request)
    {
        $request->validate([
            'platform' => 'required|string|max:50',
            'label'    => 'required|string|max:100',
            'url'      => 'required|url|max:500',
        ]);

        $max = SocialLink::max('sort_order') ?? 0;
        SocialLink::create([
            'platform'   => $request->platform,
            'label'      => $request->label,
            'url'        => $request->url,
            'sort_order' => $max + 1,
            'is_active'  => true,
        ]);

        return back()->with('success', 'Social link added.');
    }

    public function updateSocialLink(Request $request, SocialLink $link)
    {
        $request->validate([
            'platform'  => 'required|string|max:50',
            'label'     => 'required|string|max:100',
            'url'       => 'required|url|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $link->update([
            'platform'  => $request->platform,
            'label'     => $request->label,
            'url'       => $request->url,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Social link updated.');
    }

    public function destroySocialLink(SocialLink $link)
    {
        $link->delete();
        return back()->with('success', 'Social link deleted.');
    }
}
