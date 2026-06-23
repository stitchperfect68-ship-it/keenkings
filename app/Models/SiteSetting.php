<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'font_preset',
        'custom_serif_name',
        'custom_serif_path',
        'custom_sans_name',
        'custom_sans_path',
    ];

    public static function current(): self
    {
        return static::first() ?? static::create(['font_preset' => 'keenkings']);
    }

    public static function fontPresets(): array
    {
        return [
            'keenkings' => [
                'label'       => 'Keenkings Default',
                'description' => 'Cormorant Garamond + Jost',
                'serif'       => 'Cormorant Garamond',
                'sans'        => 'Jost',
                'google_url'  => 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Jost:wght@300;400;500&display=swap',
            ],
            'editorial' => [
                'label'       => 'Editorial',
                'description' => 'Playfair Display + Inter',
                'serif'       => 'Playfair Display',
                'sans'        => 'Inter',
                'google_url'  => 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,700;1,400&family=Inter:wght@300;400;500&display=swap',
            ],
            'modern' => [
                'label'       => 'Modern',
                'description' => 'DM Serif Display + DM Sans',
                'serif'       => 'DM Serif Display',
                'sans'        => 'DM Sans',
                'google_url'  => 'https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap',
            ],
            'luxe' => [
                'label'       => 'Luxe',
                'description' => 'Libre Baskerville + Raleway',
                'serif'       => 'Libre Baskerville',
                'sans'        => 'Raleway',
                'google_url'  => 'https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Raleway:wght@300;400;500&display=swap',
            ],
            'custom' => [
                'label'       => 'Custom (Upload)',
                'description' => 'Upload your own font files',
                'serif'       => null,
                'sans'        => null,
                'google_url'  => null,
            ],
        ];
    }
}
