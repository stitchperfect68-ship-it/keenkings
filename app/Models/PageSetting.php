<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSetting extends Model
{
    protected $fillable = [
        // Hero
        'hero_tag', 'hero_title', 'hero_description', 'hero_cta_primary', 'hero_cta_secondary',
        // Ticker
        'ticker_items',
        // Portfolio preview section
        'portfolio_section_tag', 'portfolio_section_title',
        // Parallax 1
        'parallax1_image_url', 'parallax1_image_path',
        'parallax1_tag', 'parallax1_title', 'parallax1_body', 'parallax1_cta',
        // Services section
        'services_tag', 'services_title', 'services_description',
        // Clients section
        'clients_tag', 'clients_title',
        // Parallax 2
        'parallax2_image_url', 'parallax2_image_path',
        'parallax2_tag', 'parallax2_title', 'parallax2_body',
        // Process section
        'process_tag', 'process_title',
        // Parallax 3
        'parallax3_image_url', 'parallax3_image_path',
        'parallax3_title', 'parallax3_body', 'parallax3_cta',
        // Contact section
        'contact_tag', 'contact_title', 'contact_description',
        'contact_email', 'contact_phone', 'contact_address', 'contact_services',
        // Portfolio page
        'portfolio_page_image_url', 'portfolio_page_image_path',
        'portfolio_page_tag', 'portfolio_page_title',
        // Blog page
        'blog_page_image_url', 'blog_page_image_path', 'blog_page_title',
        // Footer
        'footer_description', 'footer_copyright',
    ];

    protected $casts = [
        'ticker_items'     => 'array',
        'contact_services' => 'array',
    ];

    public static function current(): self
    {
        return static::first() ?? static::create([
            'hero_tag'           => 'Media Production Studio',
            'hero_title'         => 'Pictures with Love for Creativity',
            'hero_description'   => 'Keenkings Media is a dynamic media production company specializing in storytelling, digital content creation, and brand development. We bring your vision to life with precision and passion.',
            'hero_cta_primary'   => 'View Portfolio',
            'hero_cta_secondary' => 'About Us',
            'ticker_items'       => ['Portrait Photography', 'Wedding Stories', 'Editorial Work', 'Commercial Shoots', 'Nature & Landscape', 'Fine Art Prints', 'Fashion Photography', 'Event Coverage'],
            'portfolio_section_tag'   => 'Selected Works',
            'portfolio_section_title' => 'Portfolio',
            'parallax1_image_url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1800&q=80',
            'parallax1_tag'       => 'The Art of Seeing',
            'parallax1_title'     => 'Every Frame is a Decision',
            'parallax1_body'      => 'Photography is not about the camera. It is about the eye, the patience, and the quiet bravery to press the shutter at exactly the right moment.',
            'parallax1_cta'       => 'Explore the Work',
            'services_tag'         => 'What We Offer',
            'services_title'       => 'Services & Packages',
            'services_description' => 'From intimate portrait sessions to full-scale commercial productions — we tailor every shoot to your vision.',
            'clients_tag'   => 'Trusted By',
            'clients_title' => 'Our Clients',
            'parallax2_image_url' => 'https://images.unsplash.com/photo-1483653364400-eedcfb9f1f88?w=1800&q=80',
            'parallax2_tag'       => 'Behind the Lens',
            'parallax2_title'     => 'Light Changes Everything',
            'parallax2_body'      => 'From golden-hour portraits to the drama of controlled studio light — the right illumination transforms a good photograph into an unforgettable one.',
            'process_tag'   => 'How It Works',
            'process_title' => 'Our Creative Process',
            'parallax3_image_url' => 'https://images.unsplash.com/photo-1509048191080-d2984bad6ae5?w=1800&q=80',
            'parallax3_title'     => 'Ready to Create Something Beautiful?',
            'parallax3_body'      => "Whether it's a once-in-a-lifetime wedding, a brand campaign, or simply capturing who you are right now — let's talk.",
            'parallax3_cta'       => 'Start a Conversation',
            'contact_tag'         => 'Get in Touch',
            'contact_title'       => "Let's Create Something Beautiful",
            'contact_description' => 'Ready to start your photography journey? Fill out the form and we\'ll get back to you within 24 hours to discuss your project.',
            'contact_email'       => 'keenkingsmedia@gmail.com',
            'contact_phone'       => '[+260] 977 231 555',
            'contact_address'     => 'Medoreen Business Park, Plot 36998, Alick Nkhata Road, Mass Media, Lusaka',
            'contact_services'    => ['Photography', 'Videography', 'Digital Marketing', 'Branding Consultancy', 'Content Production', 'Event Coverage'],
            'portfolio_page_image_url' => 'https://images.unsplash.com/photo-1452587925148-ce544e77e70d?w=1800&q=80',
            'portfolio_page_tag'       => 'Our Work',
            'portfolio_page_title'     => 'The Portfolio',
            'blog_page_image_url' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=1800&q=80',
            'blog_page_title'     => 'Stories & Insights',
            'footer_description'  => 'Dynamic media production studio based in Lusaka. Specializing in storytelling, digital content creation, and brand development since 2016.',
            'footer_copyright'    => 'Keenkings Media. All rights reserved.',
        ]);
    }
}
