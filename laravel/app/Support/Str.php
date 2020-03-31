<?php

namespace App\Support;

use Hidehalo\Nanoid\Client;
use Illuminate\Support\Str as BaseStr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class Str extends BaseStr
{

    /**
     * @see https://zelark.github.io/nano-id-cc/
     */
    public static function nanoId(): string
    {
        $alphabet = Config::get('app.nanoid.alphabet', '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
        $length = Config::get('app.nanoid.length', 30);
        $client = new Client();
        return $client->formattedId($alphabet, $length);
    }

    /**
     * Generate a password based on XKCD's comic
     *
     * Based on the repository below, but refactored to use the best
     * of Laravel and to bypass a composer dependency issue.
     *
     * @see https://github.com/matt-allan/battery-staple
     */
    public static function generatePassword(array $options = array()): string
    {
        $options = array_merge([
            'file_path' => App::resourcePath('dictionary.txt'),
            'words' => 4,
            'delimiter' => '-',
            'min_char_length' => 5,
        ], $options);
        $contents = File::get($options['file_path']);
        return collect(explode(PHP_EOL, $contents))
            ->filter(function ($word) use ($options) {
                return static::length($word) >= $options['min_char_length'];
            })
            ->random($options['words'])
            ->implode($options['delimiter']);
    }

    /**
     * @see https://chrisblackwell.me/generate-perfect-initials-using-php/
     */
    public static function initials(string $name): string
    {
        /**
         * Convert multi-byte characters (for more exotic names) into
         * their ascii counterparts for consistency
         */
        $name = static::ascii($name);
        $words = explode(' ', static::upper($name));
        if (count($words) >= 2) {
            return static::substr($words[0], 0, 1) . static::substr(end($words), 0, 1);
        }
        $words = explode('-', static::kebab($name));
        if (count($words) > 1) {
            return static::initials(implode(' ', $words));
        }
        return static::upper(static::substr($name, 0, 2));
    }

    public static function hexColor(string $str): string
    {
        return static::substr(md5(static::lower($str)), 0, 6);
    }
}
