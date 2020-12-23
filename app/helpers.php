<?php

function hexToHsl($hex)
{
    $hex = str_replace("#", "", $hex);
    $hex = array($hex[0] . $hex[1], $hex[2] . $hex[3], $hex[4] . $hex[5]);
    $rgb = array_map(function ($part) {
        return hexdec($part) / 255;
    }, $hex);

    $max = max($rgb);
    $min = min($rgb);

    $l = ($max + $min) / 2;

    if ($max == $min) {
        $h = $s = 0;
    } else {
        $diff = $max - $min;
        $s = $l > 0.5 ? $diff / (2 - $max - $min) : $diff / ($max + $min);

        switch ($max) {
            case $rgb[0]:
                $h = ($rgb[1] - $rgb[2]) / $diff + ($rgb[1] < $rgb[2] ? 6 : 0);
                break;
            case $rgb[1]:
                $h = ($rgb[2] - $rgb[0]) / $diff + 2;
                break;
            case $rgb[2]:
                $h = ($rgb[0] - $rgb[1]) / $diff + 4;
                break;
        }

        $h /= 6;
    }

    return array($h, $s, $l);
}

function hslToHex($hsl)
{
    list($h, $s, $l) = $hsl;

    if ($s == 0) {
        $r = $g = $b = 1;
    } else {
        $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
        $p = 2 * $l - $q;

        $r = hue2rgb($p, $q, $h + 1 / 3);
        $g = hue2rgb($p, $q, $h);
        $b = hue2rgb($p, $q, $h - 1 / 3);
    }

    return "#" . rgb2hex($r) . rgb2hex($g) . rgb2hex($b);
}

function darker_color($color, $by)
{
    $color = hexToHsl($color);
    $color[2] *= $by;
    return hslToHex($color);
}

function hue2rgb($p, $q, $t)
{
    if ($t < 0) $t += 1;
    if ($t > 1) $t -= 1;
    if ($t < 1 / 6) return $p + ($q - $p) * 6 * $t;
    if ($t < 1 / 2) return $q;
    if ($t < 2 / 3) return $p + ($q - $p) * (2 / 3 - $t) * 6;

    return $p;
}

function rgb2hex($rgb)
{
    return str_pad(dechex($rgb * 255), 2, '0', STR_PAD_LEFT);
}

function get_image_color($Image, $TopLeft = true)
{
    $type = exif_imagetype($Image);
    switch ($type) {

        case IMAGETYPE_JPEG:
            $im = imagecreatefromjpeg($Image);
            break;
        case IMAGETYPE_PNG:
            $im = imagecreatefrompng($Image);
            break;
        default :
            return false;
    }

    if ($TopLeft) {
        $x = 10;
        $y = 15;
    } else {
        $x = imagesx($im) - 10;
        $y = imagesy($im) - 15;
    }

    $rgb = imagecolorat($im, $x, $y);
    $r = ($rgb >> 16) & 0xFF;
    $g = ($rgb >> 8) & 0xFF;
    $b = $rgb & 0xFF;

    return sprintf("#%02x%02x%02x", $r, $g, $b);
    //implode("," , [$r , $g , $b])
}

function randomId()
{
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $BookID = substr(str_shuffle(str_repeat($pool, 5)), 0, 12);

    $validator = Validator::make(
        ['BookID' => $BookID],
        ['BookID' => 'unique:books,BookID']
    );

    if ($validator->fails())
        return randomId();

    return $BookID;
}
