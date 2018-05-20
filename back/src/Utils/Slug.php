<?php

namespace App\Utils;

class Slug
{
    const UTF = 'en_GB.utf8';
    const REPLACE = '~[^\\pL\d.]+~u';
    const OUT_CHARSET = 'us-ascii//TRANSLIT';
    const PATTERN = '~[^-\w.]+~';

    public static function slugger(string $string, ?string $replace = '-'): string
    {
        setlocale(LC_CTYPE, self::UTF);
        $string = strip_tags($string); //remove tags
        $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
        $string = preg_replace(self::REPLACE, $replace, $string);
        $string = trim($string, '-');
        $string = iconv('utf-8',self::OUT_CHARSET , $string);
        $string = strtolower($string);
        $string = preg_replace(self::PATTERN, '', $string);
        $string = trim($string, '.');
        return $string;
    }
}
