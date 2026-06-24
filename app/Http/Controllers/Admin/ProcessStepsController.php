<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcessStep;
use Illuminate\Http\Request;

class ProcessStepsController extends Controller
{
    public function index()
    {
        $steps = ProcessStep::orderBy('sort_order')->get();
        return view('admin.pages.process-steps.index', compact('steps'));
    }

    public function create()
    {
        return view('admin.pages.process-steps.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['is_active']  = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? ProcessStep::max('sort_order') + 1;

        ProcessStep::create($data);
        return redirect()->route('admin.process-steps.index')->with('success', 'Process step created.');
    }

    public function edit(ProcessStep $processStep)
    {
        return view('admin.pages.process-steps.form', ['step' => $processStep]);
    }

    public function update(Request $request, ProcessStep $processStep)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $processStep->update($data);
        return redirect()->route('admin.process-steps.index')->with('success', 'Process step updated.');
    }

    public function destroy(ProcessStep $processStep)
    {
        $processStep->delete();
        return redirect()->route('admin.process-steps.index')->with('success', 'Process step deleted.');
    }
}
