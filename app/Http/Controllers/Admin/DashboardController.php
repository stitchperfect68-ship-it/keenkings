<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use App\Models\ContactEnquiry;
use App\Models\HeroSlide;
use App\Models\Testimonial;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'portfolio'   => PortfolioItem::count(),
            'active'      => PortfolioItem::where('is_active', true)->count(),
            'enquiries'   => ContactEnquiry::count(),
            'new_enquiries' => ContactEnquiry::where('status', 'new')->count(),
            'hero_slides' => HeroSlide::count(),
            'testimonials'=> Testimonial::count(),
            'services'    => Service::count(),
        ];

        $recentEnquiries = ContactEnquiry::latest()->take(5)->get();
        $recentPortfolio = PortfolioItem::latest()->take(6)->get();

        return view('admin.pages.dashboard', compact('stats', 'recentEnquiries', 'recentPortfolio'));
    }
}
