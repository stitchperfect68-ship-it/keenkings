<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'font_preset',
        'logo_path',
        'logo_url',
        'heading_font',
        'body_font',
        'custom_serif_name',
        'custom_serif_path',
        'custom_sans_name',
        'custom_sans_path',
    ];

    public static function current(): self
    {
        return static::first() ?? static::create([
            'font_preset'  => 'google',
            'heading_font' => 'Cormorant Garamond',
            'body_font'    => 'Jost',
        ]);
    }

    public static function headingFonts(): array
    {
        return [
            'Serif' => [
                'Cormorant Garamond',
                'Playfair Display',
                'Lora',
                'Merriweather',
                'EB Garamond',
                'Libre Baskerville',
                'Crimson Text',
                'Spectral',
                'Fraunces',
                'Zilla Slab',
            ],
            'Display' => [
                'DM Serif Display',
                'Bodoni Moda',
                'Cinzel',
                'Josefin Slab',
                'Rufina',
                'Abril Fatface',
                'Yeseva One',
                'Italiana',
            ],
            'Modern Sans' => [
                'Raleway',
                'Oswald',
                'Montserrat',
                'Bebas Neue',
                'Archivo',
                'Barlow Condensed',
            ],
        ];
    }

    public static function bodyFonts(): array
    {
        return [
            'Geometric Sans' => [
                'Jost',
                'DM Sans',
                'Poppins',
                'Outfit',
                'Urbanist',
                'Lexend',
                'Figtree',
                'Nunito',
            ],
            'Humanist Sans' => [
                'Inter',
                'Lato',
                'Open Sans',
                'Work Sans',
                'Barlow',
                'Mulish',
                'Karla',
                'Manrope',
                'Plus Jakarta Sans',
                'Source Sans 3',
            ],
            'Transitional' => [
                'Raleway',
                'Montserrat',
                'Josefin Sans',
                'Quicksand',
            ],
        ];
    }

    public static function googleFontsUrl(string $headingFont, string $bodyFont): string
    {
        $encode = fn($f) => str_replace(' ', '+', $f);
        $h = $encode($headingFont);
        $b = $encode($bodyFont);
        return "https://fonts.googleapis.com/css2?family={$h}:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400&family={$b}:wght@300;400;500&display=swap";
    }
}
