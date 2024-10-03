<?php

namespace Core;

use Generator;

class Captcha
{

    public function generateString()
    {
        // Generate random CAPTCHA text
        $captcha_text = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6);
        return $captcha_text;
    }

    public function generateImage($captcha_text)
    {
        // Create an image
        $width = 200;
        $height = 50;
        $image = imagecreate($width, $height);

        // Define colors
        $bg_color = imagecolorallocate($image, 255, 255, 255); // White background
        $text_color = imagecolorallocate($image, 0, 0, 0);     // Black text
        $noise_color = imagecolorallocate($image, 100, 100, 100); // Gray noise

        // Add random noise
        for ($i = 0; $i < 50; $i++) {
            imageline($image, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $noise_color);
        }

        // Path to TTF font
        $font_path = base_path("/public/fonts/Arial.ttf");

        // Font size
        $font_size = 20;

        // Calculate text position to center it
        $bbox = imagettfbbox($font_size, 0, $font_path, $captcha_text);
        $x = ($width - ($bbox[2] - $bbox[0])) / 2;  // Center horizontally
        $y = ($height - ($bbox[1] - $bbox[7])) / 2 + $font_size;  // Center vertically

        // Add CAPTCHA text to the image using a custom TrueType font
        imagettftext($image, $font_size, 0, $x, $y, $text_color, $font_path, $captcha_text);

        $id = uniqid();
        $_SESSION["captcha"]["id"] = $id;

        // Output the image as PNG
        $file_path = base_path("/public/images/captcha/$id.png");
        imagepng($image, $file_path);

        // Clean up
        imagedestroy($image);

        return $file_path;
    }


    public function generateCaptcha()
    {
        $captcha_text = $this->generateString();

        // Store the CAPTCHA text in a session
        $_SESSION['captcha']['text'] = $captcha_text;

        $this->generateImage($captcha_text);
    }
}
