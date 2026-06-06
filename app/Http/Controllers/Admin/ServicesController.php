<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    private const ICONS = [
        'camera','video','pen-tool','trending-up','users','star','image',
        'aperture','film','layout','package','bar-chart-2','globe','heart','award',
    ];

    public function index()
    {
        $services = Service::orderBy('sort_order')->get();
        $icons    = self::ICONS;
        return view('admin.pages.services.index', compact('services', 'icons'));
    }

    public function create()
    {
        $icons = self::ICONS;
        return view('admin.pages.services.form', compact('icons'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'icon'        => 'required|string|max:50',
            'title'       => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'items'       => 'nullable|string',
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['items']     = $this->parseItems($request->input('items', ''));
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order']= $data['sort_order'] ?? Service::max('sort_order') + 1;

        Service::create($data);
        return redirect()->route('admin.services.index')->with('success', 'Service created.');
    }

    public function edit(Service $service)
    {
        $icons = self::ICONS;
        return view('admin.pages.services.form', compact('service', 'icons'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'icon'        => 'required|string|max:50',
            'title'       => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'items'       => 'nullable|string',
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['items']     = $this->parseItems($request->input('items', ''));
        $data['is_active'] = $request->boolean('is_active');

        $service->update($data);
        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }

    private function parseItems(string $raw): array
    {
        return array_filter(array_map('trim', explode("\n", $raw)));
    }
}
