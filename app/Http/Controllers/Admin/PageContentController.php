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
            'ticker_items'       => 'nullable|string',
            'portfolio_section_tag'   => 'nullable|string|max:100',
            'portfolio_section_title' => 'nullable|string|max:200',
            'parallax1_tag'   => 'nullable|string|max:100',
            'parallax1_title' => 'nullable|string|max:200',
            'parallax1_body'  => 'nullable|string|max:1000',
            'parallax1_cta'   => 'nullable|string|max:100',
            'parallax1_image_url'  => 'nullable|url|max:500',
            'parallax1_image_file' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'services_tag'         => 'nullable|string|max:100',
            'services_title'       => 'nullable|string|max:200',
            'services_description' => 'nullable|string|max:500',
            'clients_tag'   => 'nullable|string|max:100',
            'clients_title' => 'nullable|string|max:200',
            'parallax2_tag'   => 'nullable|string|max:100',
            'parallax2_title' => 'nullable|string|max:200',
            'parallax2_body'  => 'nullable|string|max:1000',
            'parallax2_image_url'  => 'nullable|url|max:500',
            'parallax2_image_file' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'process_tag'   => 'nullable|string|max:100',
            'process_title' => 'nullable|string|max:200',
            'parallax3_title' => 'nullable|string|max:200',
            'parallax3_body'  => 'nullable|string|max:1000',
            'parallax3_cta'   => 'nullable|string|max:100',
            'parallax3_image_url'  => 'nullable|url|max:500',
            'parallax3_image_file' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'contact_tag'         => 'nullable|string|max:100',
            'contact_title'       => 'nullable|string|max:200',
            'contact_description' => 'nullable|string|max:500',
            'contact_email'       => 'nullable|email|max:200',
            'contact_phone'       => 'nullable|string|max:100',
            'contact_address'     => 'nullable|string|max:500',
            'contact_services'    => 'nullable|string',
            'portfolio_page_tag'       => 'nullable|string|max:100',
            'portfolio_page_title'     => 'nullable|string|max:200',
            'portfolio_page_image_url'  => 'nullable|url|max:500',
            'portfolio_page_image_file' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'blog_page_title'     => 'nullable|string|max:200',
            'blog_page_image_url'  => 'nullable|url|max:500',
            'blog_page_image_file' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $settings = PageSetting::current();
        $data = $request->except(['_token', '_method',
            'parallax1_image_file', 'parallax2_image_file', 'parallax3_image_file',
            'portfolio_page_image_file', 'blog_page_image_file',
        ]);

        // Parse textarea-based JSON fields (one per line)
        if (isset($data['ticker_items'])) {
            $data['ticker_items'] = array_values(array_filter(
                array_map('trim', explode("\n", $data['ticker_items']))
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

        $settings->update($data);

        return back()->with('success', 'Page content updated successfully.');
    }
}
