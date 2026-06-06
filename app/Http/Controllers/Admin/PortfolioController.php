<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    private const PARENT_CATS = ['photography', 'videography', 'graphics'];

    private const SUB_CATS = [
        'photography' => ['graduation','wedding','chilanga-mulilo','indoor','outdoor','studio','corporate','creative'],
        'videography' => ['wedding','corporate','creative','nature','time-lapse','product','fashion'],
        'graphics'    => ['logo-design','brochure-layout','web-banner','social-media-post','infographic','packaging-design'],
    ];

    private const SIZES = ['' => 'Square (1×1)', 'wide' => 'Wide (2×1)', 'tall' => 'Tall (1×2)', 'feature' => 'Feature (2×2)'];

    public function index(Request $request)
    {
        $query = PortfolioItem::query();

        if ($request->filled('parent')) {
            $query->where('parent_category', $request->parent);
        }
        if ($request->filled('sub')) {
            $query->where('sub_category', $request->sub);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $items      = $query->orderBy('sort_order')->orderBy('id', 'desc')->paginate(24);
        $parentCats = self::PARENT_CATS;
        $subCats    = self::SUB_CATS;
        $sizes      = self::SIZES;

        return view('admin.pages.portfolio.index', compact('items', 'parentCats', 'subCats', 'sizes'));
    }

    public function create()
    {
        $parentCats = self::PARENT_CATS;
        $subCats    = self::SUB_CATS;
        $sizes      = self::SIZES;
        return view('admin.pages.portfolio.form', compact('parentCats', 'subCats', 'sizes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'parent_category' => 'required|in:photography,videography,graphics',
            'sub_category'    => 'required|string|max:100',
            'title'           => 'required|string|max:255',
            'size'            => 'nullable|in:,wide,tall,feature',
            'image_url'       => 'required_without:image_file|nullable|url|max:500',
            'image_file'      => 'nullable|image|max:5120',
            'video_url'       => 'nullable|url|max:500',
            'description'     => 'nullable|string|max:1000',
            'sort_order'      => 'nullable|integer',
            'is_active'       => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('portfolio', 'public');
            $data['image_path'] = $path;
            $data['image_url']  = Storage::url($path);
        }

        $data['size']        = $data['size'] ?? '';
        $data['is_active']   = $request->boolean('is_active', true);
        $data['sort_order']  = $data['sort_order'] ?? PortfolioItem::max('sort_order') + 1;

        PortfolioItem::create($data);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio item "' . $data['title'] . '" created successfully.');
    }

    public function edit(PortfolioItem $portfolio)
    {
        $parentCats = self::PARENT_CATS;
        $subCats    = self::SUB_CATS;
        $sizes      = self::SIZES;
        $item       = $portfolio;
        return view('admin.pages.portfolio.form', compact('item', 'parentCats', 'subCats', 'sizes'));
    }

    public function update(Request $request, PortfolioItem $portfolio)
    {
        $data = $request->validate([
            'parent_category' => 'required|in:photography,videography,graphics',
            'sub_category'    => 'required|string|max:100',
            'title'           => 'required|string|max:255',
            'size'            => 'nullable|in:,wide,tall,feature',
            'image_url'       => 'nullable|url|max:500',
            'image_file'      => 'nullable|image|max:5120',
            'video_url'       => 'nullable|url|max:500',
            'description'     => 'nullable|string|max:1000',
            'sort_order'      => 'nullable|integer',
            'is_active'       => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_file')) {
            if ($portfolio->image_path) Storage::disk('public')->delete($portfolio->image_path);
            $path = $request->file('image_file')->store('portfolio', 'public');
            $data['image_path'] = $path;
            $data['image_url']  = Storage::url($path);
        }

        $data['size']      = $data['size'] ?? '';
        $data['is_active'] = $request->boolean('is_active');

        $portfolio->update($data);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio item updated successfully.');
    }

    public function destroy(PortfolioItem $portfolio)
    {
        if ($portfolio->image_path) Storage::disk('public')->delete($portfolio->image_path);
        $title = $portfolio->title;
        $portfolio->delete();
        return redirect()->route('admin.portfolio.index')
            ->with('success', '"' . $title . '" deleted successfully.');
    }

    public function toggleActive(PortfolioItem $portfolio)
    {
        $portfolio->update(['is_active' => !$portfolio->is_active]);
        return back()->with('success', 'Item visibility updated.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->validate(['ids' => 'required|array', 'ids.*' => 'integer'])['ids'];
        $items = PortfolioItem::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->image_path) Storage::disk('public')->delete($item->image_path);
            $item->delete();
        }
        return back()->with('success', count($ids) . ' items deleted.');
    }
}
