<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    protected $table    = 'about_content';
    protected $fillable = [
        'eyebrow','heading','lead_text','body_text',
        'main_image_url','main_image_path',
        'accent_image_url','accent_image_path',
        'founded_year','pillar_1','pillar_2','pillar_3',
    ];

    public static function getSingleton(): self
    {
        return self::first() ?? self::create([
            'eyebrow'      => 'About Keenkings Media',
            'heading'      => "Zambia's Creative Production Studio",
            'lead_text'    => 'Founded in 2016, Keenkings Media has grown into one of Lusaka\'s most trusted visual storytelling studios.',
            'body_text'    => 'From intimate graduation portraits to large-scale corporate productions, we bring the same passion and professionalism to every project.',
            'main_image_url'  => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=700&q=80',
            'accent_image_url'=> 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400&q=80',
            'founded_year' => '2016',
            'pillar_1'     => 'Vision',
            'pillar_2'     => 'Precision',
            'pillar_3'     => 'Passion',
        ]);
    }
}
