<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use Illuminate\Http\Request;

class EnquiriesController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactEnquiry::query();
        if ($request->filled('status')) $query->where('status', $request->status);
        $enquiries = $query->latest()->paginate(20);
        return view('admin.pages.enquiries.index', compact('enquiries'));
    }

    public function show(ContactEnquiry $enquiry)
    {
        if ($enquiry->status === 'new') {
            $enquiry->update(['status' => 'read', 'read_at' => now()]);
        }
        return view('admin.pages.enquiries.show', compact('enquiry'));
    }

    public function updateStatus(Request $request, ContactEnquiry $enquiry)
    {
        $enquiry->update(['status' => $request->validate(['status' => 'required|in:new,read,replied,archived'])['status']]);
        return back()->with('success', 'Status updated.');
    }

    public function destroy(ContactEnquiry $enquiry)
    {
        $enquiry->delete();
        return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry deleted.');
    }
}
