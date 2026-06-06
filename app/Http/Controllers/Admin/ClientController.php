<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::orderBy('row')->orderBy('sort_order')->orderBy('name');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('row')) {
            $query->where('row', $request->row);
        }

        $clients = $query->paginate(24);
        return view('admin.pages.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.pages.clients.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'logo_url'    => 'nullable|url|max:500',
            'website_url' => 'nullable|url|max:500',
            'row'         => 'required|integer|between:1,3',
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Client::create($data);

        return redirect()->route('admin.clients.index')
                         ->with('success', 'Client added successfully.');
    }

    public function edit(Client $client)
    {
        return view('admin.pages.clients.form', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'logo_url'    => 'nullable|url|max:500',
            'website_url' => 'nullable|url|max:500',
            'row'         => 'required|integer|between:1,3',
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $client->update($data);

        return redirect()->route('admin.clients.index')
                         ->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return back()->with('success', 'Client removed.');
    }

    public function toggleActive(Client $client)
    {
        $client->update(['is_active' => !$client->is_active]);
        return back()->with('success', $client->is_active ? 'Client shown.' : 'Client hidden.');
    }
}
