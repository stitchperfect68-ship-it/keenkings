<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminUser;
use App\Models\HeroSlide;
use App\Models\AboutContent;
use App\Models\PageSetting;
use App\Models\Stat;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\PortfolioItem;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin User ──
        AdminUser::updateOrCreate(['email' => 'admin@keenkingsmedia.com'], [
            'name'      => 'Keenkings Admin',
            'password'  => Hash::make('keenkings2016'),
            'is_active' => true,
        ]);

        // ── Hero Slides ── (main image from static index.html)
        HeroSlide::truncate();
        HeroSlide::create([
            'image_url'   => 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?w=1800&q=80',
            'heading'     => null,
            'subheading'  => null,
            'sort_order'  => 1,
            'is_active'   => true,
        ]);

        // ── About Content ── (exact text from static index.html about section)
        AboutContent::truncate();
        AboutContent::create([
            'eyebrow'          => 'About the Studio',
            'heading'          => 'Where Vision Meets Innovation',
            'lead_text'        => 'Keenkings Media is a dynamic media production company specializing in storytelling, digital content creation, and brand development. We are dedicated to producing high-quality visual narratives and brand identities.',
            'body_text'        => 'Established in 2016, we have evolved into a trusted partner for businesses and organizations looking to enhance their digital and media presence. Based in Lusaka, we serve clients with excellence and professionalism.',
            'main_image_url'   => 'https://i.ibb.co/chZXP5Lp/team-3.jpg',
            'accent_image_url' => 'https://i.ibb.co/DHZDX87Y/team-1.jpg',
            'founded_year'     => '2016',
            'pillar_1'         => 'Photography',
            'pillar_2'         => 'Videography',
            'pillar_3'         => 'Branding',
        ]);

        // ── Stats ── (from static index.html stats bar)
        Stat::truncate();
        $stats = [
            ['value' => '15+',   'label' => 'Team Members',   'sort_order' => 1],
            ['value' => '290+',  'label' => 'Total Projects',  'sort_order' => 2],
            ['value' => '1600+', 'label' => 'Following',       'sort_order' => 3],
            ['value' => '240+',  'label' => 'Happy Clients',   'sort_order' => 4],
        ];
        foreach ($stats as $s) Stat::create($s + ['is_active' => true]);

        // ── Services ── (from static index.html services section)
        Service::truncate();
        $services = [
            ['title' => 'Photography & Visual Assets',      'description' => 'Expert capturing of key moments for corporate, commercial, and social events, along with product branding and advertising campaigns.',                    'icon' => 'camera',      'items' => ['Corporate Events', 'Wedding Photography', 'Product Branding', 'Advertising Campaigns'], 'sort_order' => 1],
            ['title' => 'Corporate & Brand Storytelling',   'description' => 'High-quality documentaries and compelling stories that highlight achievements and impact for clients from concept to completion.',                       'icon' => 'video',       'items' => ['Brand Documentaries', 'Achievement Films', 'Impact Stories', 'Concept to Completion'],  'sort_order' => 2],
            ['title' => 'Content Production',               'description' => 'Corporate documentaries, promotional videos, and brand stories that elevate business visibility and market positioning.',                               'icon' => 'film',        'items' => ['Promotional Videos', 'Corporate Docs', 'Brand Stories', 'Market Positioning'],          'sort_order' => 3],
            ['title' => 'Digital Marketing & Social Media', 'description' => 'Strategic digital content like short videos and motion graphics specifically for social media to boost engagement and brand awareness.',                 'icon' => 'trending-up', 'items' => ['Short Videos', 'Motion Graphics', 'Social Campaigns', 'Engagement Strategy'],          'sort_order' => 4],
            ['title' => 'Event Coverage',                   'description' => 'High-quality photography and videography services for weddings, graduations, corporate events, and social gatherings.',                                 'icon' => 'users',       'items' => ['Weddings', 'Graduations', 'Corporate Events', 'Social Gatherings'],                      'sort_order' => 5],
            ['title' => 'Media Consultancy',                'description' => 'Expert consultancy in branding, media production, and marketing strategies to effectively position your brand in the digital space.',                   'icon' => 'star',        'items' => ['Brand Strategy', 'Production Planning', 'Marketing Strategy', 'Digital Positioning'],    'sort_order' => 6],
        ];
        foreach ($services as $s) Service::create($s + ['is_active' => true]);

        // ── Testimonials ── (from static zoomin.js defaults)
        Testimonial::truncate();
        $testimonials = [
            ['quote' => 'Keenkings Media brought our vision to life with their incredible storytelling. Their passion and creativity are truly unmatched, making the entire process a pleasure.', 'name' => 'Joshua Phiri',  'role' => 'Editor, 2024',      'avatar_url' => 'https://i.ibb.co/Lhpg3qYZ/team-2.jpg',  'sort_order' => 1],
            ['quote' => 'The portrait session was an incredible experience. The Keenkings team has a gift for making you feel at ease, and the results were beyond anything I imagined.',          'name' => 'Daniel Musonda', 'role' => 'Founder, 2024',     'avatar_url' => 'https://i.ibb.co/DHZDX87Y/team-1.jpg',  'sort_order' => 2],
            ['quote' => "Our brand presence was transformed by Keenkings' vision. They understand light and story in a way that very few studios do. Exceptional.",                                'name' => 'Joyce Banda',    'role' => 'Agency CEO, 2024', 'avatar_url' => 'https://i.ibb.co/chZXP5Lp/team-3.jpg',  'sort_order' => 3],
        ];
        foreach ($testimonials as $t) Testimonial::create($t + ['is_active' => true]);

        // ── Portfolio Items ── (exact ITEMS array from static portfolio.html)
        PortfolioItem::truncate();
        $items = [
            /* ── PHOTOGRAPHY ── */
            ['parent_category' => 'photography', 'sub_category' => 'graduation',      'title' => 'Graduation Ceremony',   'size' => 'feature', 'image_url' => 'https://i.ibb.co/dS0ng0h/gd-1.jpg',        'sort_order' => 1],
            ['parent_category' => 'photography', 'sub_category' => 'graduation',      'title' => 'The Milestone',         'size' => 'tall',    'image_url' => 'https://i.ibb.co/cK83N1xq/gd-2.jpg',       'sort_order' => 2],
            ['parent_category' => 'photography', 'sub_category' => 'graduation',      'title' => 'Achievement',           'size' => '',        'image_url' => 'https://i.ibb.co/RkrkC01J/gd-3.jpg',       'sort_order' => 3],
            ['parent_category' => 'photography', 'sub_category' => 'wedding',         'title' => 'Forever Yours',         'size' => 'wide',    'image_url' => 'https://i.ibb.co/ccxwnLHr/wed-1.jpg',      'sort_order' => 4],
            ['parent_category' => 'photography', 'sub_category' => 'wedding',         'title' => 'Golden Vows',           'size' => 'tall',    'image_url' => 'https://i.ibb.co/zhhZ0YVc/wed-2.jpg',      'sort_order' => 5],
            ['parent_category' => 'photography', 'sub_category' => 'wedding',         'title' => 'The Celebration',       'size' => '',        'image_url' => 'https://i.ibb.co/1Gnpq7fz/wed-3.jpg',      'sort_order' => 6],
            ['parent_category' => 'photography', 'sub_category' => 'chilanga-mulilo', 'title' => 'The Feast',             'size' => 'wide',    'image_url' => 'https://i.ibb.co/LdPBN8Tx/cm-1.jpg',       'sort_order' => 7],
            ['parent_category' => 'photography', 'sub_category' => 'chilanga-mulilo', 'title' => 'Traditional Rites',     'size' => '',        'image_url' => 'https://i.ibb.co/Tx3mtD8K/cm-2.jpg',       'sort_order' => 8],
            ['parent_category' => 'photography', 'sub_category' => 'chilanga-mulilo', 'title' => 'Cultural Heritage',     'size' => 'tall',    'image_url' => 'https://i.ibb.co/nMyVJ6Wc/cm-3.jpg',       'sort_order' => 9],
            ['parent_category' => 'photography', 'sub_category' => 'indoor',          'title' => 'Interior Study',        'size' => 'feature', 'image_url' => 'https://i.ibb.co/gZ51TRXs/ind-1.jpg',      'sort_order' => 10],
            ['parent_category' => 'photography', 'sub_category' => 'indoor',          'title' => 'Natural Light',         'size' => '',        'image_url' => 'https://i.ibb.co/4ZC1vs0M/ind-2.jpg',      'sort_order' => 11],
            ['parent_category' => 'photography', 'sub_category' => 'indoor',          'title' => 'Modern Spaces',         'size' => 'tall',    'image_url' => 'https://i.ibb.co/zhSP1Jq3/ind-3.jpg',      'sort_order' => 12],
            ['parent_category' => 'photography', 'sub_category' => 'outdoor',         'title' => 'Into the Wild',         'size' => 'wide',    'image_url' => 'https://i.ibb.co/3YmXSzcQ/out-1.jpg',      'sort_order' => 13],
            ['parent_category' => 'photography', 'sub_category' => 'outdoor',         'title' => 'Scenic Views',          'size' => '',        'image_url' => 'https://i.ibb.co/RkVQHSvW/out-2.jpg',      'sort_order' => 14],
            ['parent_category' => 'photography', 'sub_category' => 'outdoor',         'title' => 'Adventure Awaits',      'size' => 'tall',    'image_url' => 'https://i.ibb.co/VWdMX16G/out-3.jpg',      'sort_order' => 15],
            ['parent_category' => 'photography', 'sub_category' => 'studio',          'title' => 'Studio Portrait',       'size' => 'tall',    'image_url' => 'https://i.ibb.co/zVMCnpD1/stu-1.jpg',      'sort_order' => 16],
            ['parent_category' => 'photography', 'sub_category' => 'studio',          'title' => 'Professional Look',     'size' => '',        'image_url' => 'https://i.ibb.co/0yZvhY1c/stu-2.jpg',      'sort_order' => 17],
            ['parent_category' => 'photography', 'sub_category' => 'studio',          'title' => 'Editorial Shoot',       'size' => 'wide',    'image_url' => 'https://i.ibb.co/Y4r1Ykj8/stu-3.jpg',      'sort_order' => 18],
            ['parent_category' => 'photography', 'sub_category' => 'corporate',       'title' => 'Business Excellence',   'size' => 'wide',    'image_url' => 'https://i.ibb.co/Pzsn97fm/cp-1.jpg',       'sort_order' => 19],
            ['parent_category' => 'photography', 'sub_category' => 'corporate',       'title' => 'Team Spirit',           'size' => '',        'image_url' => 'https://i.ibb.co/JRRP5fjx/cp-2.jpg',       'sort_order' => 20],
            ['parent_category' => 'photography', 'sub_category' => 'corporate',       'title' => 'Executive Session',     'size' => 'tall',    'image_url' => 'https://i.ibb.co/Z1f6nWZy/cp-3.jpg',       'sort_order' => 21],
            ['parent_category' => 'photography', 'sub_category' => 'creative',        'title' => 'Creative Vision',       'size' => 'feature', 'image_url' => 'https://i.ibb.co/PZTq47BR/crt-1.jpg',      'sort_order' => 22],
            ['parent_category' => 'photography', 'sub_category' => 'creative',        'title' => 'Artistic Form',         'size' => '',        'image_url' => 'https://i.ibb.co/v6jb3dYG/crt-2.jpg',      'sort_order' => 23],

            /* ── VIDEOGRAPHY ── */
            ['parent_category' => 'videography', 'sub_category' => 'nature',  'title' => 'Epic Nature Drone Video',  'size' => 'feature', 'image_url' => 'https://img.youtube.com/vi/LXb3EKWsInQ/hqdefault.jpg', 'video_url' => 'https://www.youtube.com/embed/LXb3EKWsInQ', 'sort_order' => 24],
            ['parent_category' => 'videography', 'sub_category' => 'wedding', 'title' => 'Wedding Highlight Reel',   'size' => 'wide',    'image_url' => 'https://img.youtube.com/vi/LXb3EKWsInQ/hqdefault.jpg', 'video_url' => 'https://www.youtube.com/embed/LXb3EKWsInQ', 'sort_order' => 25],

            /* ── GRAPHICS ── */
            ['parent_category' => 'graphics', 'sub_category' => 'logo',     'title' => 'Brand Identity',    'size' => 'feature', 'image_url' => 'https://i.ibb.co/C5ZP92ch/gd.jpg', 'sort_order' => 26],
            ['parent_category' => 'graphics', 'sub_category' => 'brochure', 'title' => 'Corporate Layout',  'size' => 'tall',    'image_url' => 'https://i.ibb.co/C5ZP92ch/gd.jpg', 'sort_order' => 27],
        ];
        foreach ($items as $item) PortfolioItem::create($item + ['is_active' => true]);

        // ── Page Settings (singleton row) ──
        if (!PageSetting::exists()) {
            PageSetting::create(PageSetting::getDefaults());
        }

        // ── Clients ──
        $this->call(ClientSeeder::class);
    }
}
