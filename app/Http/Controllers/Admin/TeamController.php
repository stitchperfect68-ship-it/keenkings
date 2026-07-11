<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index()
    {
        $members = TeamMember::orderBy('sort_order')->get();
        return view('admin.pages.team.index', compact('members'));
    }

    public function create()
    {
        return view('admin.pages.team.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'role'       => 'nullable|string|max:100',
            'bio'        => 'nullable|string',
            'image_url'  => 'nullable|string|max:500',
            'image_file' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:3072',
            'sort_order' => 'nullable|integer',
            'is_active'  => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('team', 'public');
            $data['image_path'] = $path;
            $data['image_url']  = asset('storage/' . $path);
        }

        unset($data['image_file']);
        $data['is_active']  = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? TeamMember::max('sort_order') + 1;

        TeamMember::create($data);
        return redirect()->route('admin.team.index')->with('success', 'Team member added.');
    }

    public function edit(TeamMember $team)
    {
        return view('admin.pages.team.form', ['member' => $team]);
    }

    public function update(Request $request, TeamMember $team)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'role'       => 'nullable|string|max:100',
            'bio'        => 'nullable|string',
            'image_url'  => 'nullable|string|max:500',
            'image_file' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:3072',
            'sort_order' => 'nullable|integer',
            'is_active'  => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_file')) {
            if ($team->image_path) {
                Storage::disk('public')->delete($team->image_path);
            }
            $path = $request->file('image_file')->store('team', 'public');
            $data['image_path'] = $path;
            $data['image_url']  = asset('storage/' . $path);
        }

        unset($data['image_file']);
        $data['is_active'] = $request->boolean('is_active');

        $team->update($data);
        return redirect()->route('admin.team.index')->with('success', 'Team member updated.');
    }

    public function destroy(TeamMember $team)
    {
        if ($team->image_path) {
            Storage::disk('public')->delete($team->image_path);
        }
        $team->delete();
        return redirect()->route('admin.team.index')->with('success', 'Team member deleted.');
    }
}
