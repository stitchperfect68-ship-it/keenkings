<?php

namespace App\Http\Controllers;

class OgImageController extends Controller
{
    public function show()
    {
        $width  = 1200;
        $height = 630;

        $canvas = imagecreatetruecolor($width, $height);

        $black = imagecolorallocate($canvas, 0, 0, 0);
        $teal  = imagecolorallocate($canvas, 137, 221, 223);
        $white = imagecolorallocate($canvas, 255, 255, 255);
        $dim   = imagecolorallocate($canvas, 180, 180, 180);

        // Black background
        imagefilledrectangle($canvas, 0, 0, $width, $height, $black);

        // Subtle vertical side lines for depth
        $lineColor = imagecolorallocatealpha($canvas, 255, 255, 255, 120);
        imageline($canvas, 80, 60, 80, $height - 60, $lineColor);
        imageline($canvas, $width - 80, 60, $width - 80, $height - 60, $lineColor);

        // Teal bottom accent bar
        imagefilledrectangle($canvas, 0, $height - 5, $width, $height, $teal);

        // White logo centered on canvas
        $logoPath = public_path('images/KEEN-KINGS-LOGO WHITE.png');
        if (file_exists($logoPath)) {
            $logo  = @imagecreatefrompng($logoPath);
            if ($logo) {
                imagealphablending($canvas, true);

                $logoW = imagesx($logo);
                $logoH = imagesy($logo);

                // Scale to max 480px wide while keeping aspect ratio
                $maxW    = 480;
                $scale   = min(1, $maxW / $logoW);
                $destW   = (int) ($logoW * $scale);
                $destH   = (int) ($logoH * $scale);
                $destX   = (int) (($width  - $destW) / 2);
                $destY   = (int) (($height - $destH) / 2) - 30;

                imagecopyresampled($canvas, $logo, $destX, $destY, 0, 0, $destW, $destH, $logoW, $logoH);
                imagedestroy($logo);
            }
        }

        // Tagline below logo
        $font     = 4; // built-in GD font
        $tagline  = 'PRODUCTION MEDIA HOUSE';
        $charW    = imagefontwidth($font);
        $textW    = $charW * strlen($tagline);
        $textX    = (int) (($width - $textW) / 2);
        imagestring($canvas, $font, $textX, (int) ($height / 2) + 60, $tagline, $dim);

        // Teal thin separator above tagline
        imagefilledrectangle($canvas, (int)(($width - 120) / 2), (int)($height / 2) + 48, (int)(($width + 120) / 2), (int)($height / 2) + 49, $teal);

        header('Content-Type: image/png');
        header('Cache-Control: public, max-age=604800');
        imagepng($canvas);
        imagedestroy($canvas);
    }
}
