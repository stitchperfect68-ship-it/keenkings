<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;
use App\Models\PageSetting;

class PortfolioController extends Controller
{
    public function index()
    {
        $items = PortfolioItem::active()
            ->orderBy('sort_order')
            ->get()
            ->map(fn($i) => $i->toFrontend())
            ->values()
            ->toArray();

        $subs         = $this->getSubCategories();
        $pageSettings = PageSetting::current();
        return view('pages.portfolio', compact('items', 'subs', 'pageSettings'));
    }

    // Returns SUBS in {v, l} format matching the static portfolio.html JS
    private function getSubCategories(): array
    {
        return [
            'photography' => [
                ['v' => 'graduation',     'l' => 'Graduation'],
                ['v' => 'wedding',        'l' => 'Wedding'],
                ['v' => 'chilanga-mulilo','l' => 'Chilanga-Mulilo'],
                ['v' => 'indoor',         'l' => 'Indoor'],
                ['v' => 'outdoor',        'l' => 'Outdoor'],
                ['v' => 'studio',         'l' => 'Studio'],
                ['v' => 'corporate',      'l' => 'Corporate'],
                ['v' => 'creative',       'l' => 'Creative'],
            ],
            'videography' => [
                ['v' => 'wedding',   'l' => 'Wedding'],
                ['v' => 'corporate', 'l' => 'Corporate'],
                ['v' => 'creative',  'l' => 'Creative'],
                ['v' => 'nature',    'l' => 'Nature'],
                ['v' => 'timelapse', 'l' => 'Time-Lapse'],
                ['v' => 'product',   'l' => 'Product'],
                ['v' => 'fashion',   'l' => 'Fashion'],
            ],
            'graphics' => [
                ['v' => 'logo',         'l' => 'Logo Design'],
                ['v' => 'brochure',     'l' => 'Brochure Layout'],
                ['v' => 'banner',       'l' => 'Web Banner'],
                ['v' => 'social-media', 'l' => 'Social Media Post'],
                ['v' => 'infographic',  'l' => 'Infographic'],
                ['v' => 'packaging',    'l' => 'Packaging Design'],
            ],
        ];
    }
}
