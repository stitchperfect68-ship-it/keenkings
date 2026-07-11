<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageContentController extends Controller
{
    public function index()
    {
        $settings = PageSetting::current();
        return view('admin.pages.page-content', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_tag'           => 'nullable|string|max:100',
            'hero_title'         => 'nullable|string|max:200',
            'hero_description'   => 'nullable|string|max:1000',
            'hero_cta_primary'   => 'nullable|string|max:100',
            'hero_cta_secondary' => 'nullable|string|max:100',
            'ticker_items'       => 'nullable|array',
            'ticker_items.*'     => 'nullable|string|max:100',
            'portfolio_section_tag'   => 'nullable|string|max:100',
            'portfolio_section_title' => 'nullable|string|max:200',
            'parallax1_tag'   => 'nullable|string|max:100',
            'parallax1_title' => 'nullable|string|max:200',
            'parallax1_body'  => 'nullable|string',
            'parallax1_cta'   => 'nullable|string|max:100',
            'parallax1_image_url'  => 'nullable|string|max:500',
            'parallax1_image_file' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'services_tag'         => 'nullable|string|max:100',
            'services_title'       => 'nullable|string|max:200',
            'services_description' => 'nullable|string',
            'clients_tag'   => 'nullable|string|max:100',
            'clients_title' => 'nullable|string|max:200',
            'parallax2_tag'   => 'nullable|string|max:100',
            'parallax2_title' => 'nullable|string|max:200',
            'parallax2_body'  => 'nullable|string',
            'parallax2_image_url'  => 'nullable|string|max:500',
            'parallax2_image_file' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'process_tag'   => 'nullable|string|max:100',
            'process_title' => 'nullable|string|max:200',
            'parallax3_title' => 'nullable|string|max:200',
            'parallax3_body'  => 'nullable|string',
            'parallax3_cta'   => 'nullable|string|max:100',
            'parallax3_image_url'  => 'nullable|string|max:500',
            'parallax3_image_file' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'contact_tag'         => 'nullable|string|max:100',
            'contact_title'       => 'nullable|string|max:200',
            'contact_description' => 'nullable|string',
            'contact_email'       => 'nullable|string|max:200',
            'contact_phone'       => 'nullable|string|max:100',
            'contact_address'     => 'nullable|string',
            'contact_services'    => 'nullable|string',
            'portfolio_page_tag'       => 'nullable|string|max:100',
            'portfolio_page_title'     => 'nullable|string|max:200',
            'portfolio_page_image_url'  => 'nullable|string|max:500',
            'portfolio_page_image_file' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'blog_page_title'     => 'nullable|string|max:200',
            'blog_page_image_url'  => 'nullable|string|max:500',
            'blog_page_image_file' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'footer_description' => 'nullable|string',
            'footer_copyright'   => 'nullable|string|max:200',
        ]);

        // Get or create the settings row — ensures it's DB-backed even on first deploy
        try {
            $settings = PageSetting::first() ?? PageSetting::create(PageSetting::getDefaults());
        } catch (\Exception $e) {
            return back()->with('error', 'Database error — the page_settings table may not exist yet. Run migrations on your server. (' . $e->getMessage() . ')');
        }

        $data = $request->except(['_token', '_method', '_tab',
            'parallax1_image_file', 'parallax2_image_file', 'parallax3_image_file',
            'portfolio_page_image_file', 'blog_page_image_file',
        ]);

        // Ticker items arrive as ticker_items[] array; strip blanks
        if (isset($data['ticker_items']) && is_array($data['ticker_items'])) {
            $data['ticker_items'] = array_values(array_filter(
                array_map('trim', $data['ticker_items'])
            ));
        }
        if (isset($data['contact_services'])) {
            $data['contact_services'] = array_values(array_filter(
                array_map('trim', explode("\n", $data['contact_services']))
            ));
        }

        // Handle image uploads
        foreach (['parallax1', 'parallax2', 'parallax3', 'portfolio_page', 'blog_page'] as $key) {
            $fileKey = $key . '_image_file';
            $pathKey = $key . '_image_path';
            $urlKey  = $key . '_image_url';
            if ($request->hasFile($fileKey)) {
                if ($settings->$pathKey) {
                    Storage::disk('public')->delete($settings->$pathKey);
                }
                $path = $request->file($fileKey)->store('page-images', 'public');
                $data[$pathKey] = $path;
                $data[$urlKey]  = asset('storage/' . $path);
            }
        }

        try {
            $settings->update($data);
        } catch (\Exception $e) {
            return back()->with('error', 'Save failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Page content updated successfully.');
    }
}
