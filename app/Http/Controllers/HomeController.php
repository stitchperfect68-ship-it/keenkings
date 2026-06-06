<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Models\AboutContent;
use App\Models\Stat;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\PortfolioItem;
use App\Models\Client;

class HomeController extends Controller
{
    public function index()
    {
        $heroSlides = HeroSlide::active()->get();
        if ($heroSlides->isEmpty()) {
            $heroSlides = collect([
                (object)['image_url' => 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?w=1800&q=80', 'heading' => null, 'subheading' => null],
            ]);
        }

        $about = AboutContent::getSingleton();

        $stats = Stat::active()->get();
        if ($stats->isEmpty()) {
            $stats = collect([
                (object)['value' => '15+',   'label' => 'Team Members'],
                (object)['value' => '290+',  'label' => 'Total Projects'],
                (object)['value' => '1600+', 'label' => 'Following'],
                (object)['value' => '240+',  'label' => 'Happy Clients'],
            ]);
        }

        $services = Service::active()->get();
        if ($services->isEmpty()) {
            $services = collect([
                (object)['title' => 'Photography & Visual Assets',       'description' => 'Expert capturing of key moments for corporate, commercial, and social events, along with product branding and advertising campaigns.'],
                (object)['title' => 'Corporate & Brand Storytelling',    'description' => 'High-quality documentaries and compelling stories that highlight achievements and impact for clients from concept to completion.'],
                (object)['title' => 'Content Production',                'description' => 'Corporate documentaries, promotional videos, and brand stories that elevate business visibility and market positioning.'],
                (object)['title' => 'Digital Marketing & Social Media',  'description' => 'Strategic digital content like short videos and motion graphics specifically for social media to boost engagement and brand awareness.'],
                (object)['title' => 'Event Coverage',                    'description' => 'High-quality photography and videography services for weddings, graduations, corporate events, and social gatherings.'],
                (object)['title' => 'Media Consultancy',                 'description' => 'Expert consultancy in branding, media production, and marketing strategies to effectively position your brand in the digital space.'],
            ]);
        }

        $testimonials = Testimonial::active()->get();
        if ($testimonials->isEmpty()) {
            $testimonials = collect([
                (object)['quote' => 'Keenkings Media brought our vision to life with their incredible storytelling. Their passion and creativity are truly unmatched, making the entire process a pleasure.', 'name' => 'Joshua Phiri',  'role' => 'Editor, 2024',      'avatar_url' => 'https://i.ibb.co/Lhpg3qYZ/team-2.jpg'],
                (object)['quote' => 'The portrait session was an incredible experience. The Keenkings team has a gift for making you feel at ease, and the results were beyond anything I imagined.',      'name' => 'Daniel Musonda', 'role' => 'Founder, 2024',     'avatar_url' => 'https://i.ibb.co/DHZDX87Y/team-1.jpg'],
                (object)['quote' => "Our brand presence was transformed by Keenkings' vision. They understand light and story in a way that very few studios do. Exceptional.",                            'name' => 'Joyce Banda',    'role' => 'Agency CEO, 2024', 'avatar_url' => 'https://i.ibb.co/chZXP5Lp/team-3.jpg'],
            ]);
        }

        // Small selection of portfolio items for the home page preview
        $previewItems = PortfolioItem::active()
            ->orderBy('sort_order')
            ->take(8)
            ->get()
            ->map(fn($i) => $i->toFrontend())
            ->values()
            ->toArray();

        if (empty($previewItems)) {
            $previewItems = [
                ['id'=>1,'p'=>'photography','s'=>'graduation','t'=>'Graduation Ceremony','sz'=>'','img'=>'https://i.ibb.co/dS0ng0h/gd-1.jpg','vid'=>''],
                ['id'=>2,'p'=>'photography','s'=>'wedding',   't'=>'Forever Yours',      'sz'=>'wide','img'=>'https://i.ibb.co/ccxwnLHr/wed-1.jpg','vid'=>''],
                ['id'=>3,'p'=>'photography','s'=>'studio',    't'=>'Studio Portrait',    'sz'=>'','img'=>'https://i.ibb.co/zVMCnpD1/stu-1.jpg','vid'=>''],
                ['id'=>4,'p'=>'videography','s'=>'nature',    't'=>'Epic Nature Drone',  'sz'=>'wide','img'=>'https://img.youtube.com/vi/LXb3EKWsInQ/hqdefault.jpg','vid'=>'https://www.youtube.com/embed/LXb3EKWsInQ'],
                ['id'=>5,'p'=>'graphics',   's'=>'logo',      't'=>'Brand Identity',     'sz'=>'','img'=>'https://i.ibb.co/C5ZP92ch/gd.jpg','vid'=>''],
            ];
        }

        // Clients grouped by row for the marquee
        $clientRows = Client::active()->get()->groupBy('row');

        return view('pages.home', compact('heroSlides', 'about', 'stats', 'services', 'testimonials', 'previewItems', 'clientRows'));
    }

    public function about()   { return view('pages.about'); }
    public function services() { return view('pages.services'); }
}
