<?php

namespace App\Support;

use Hidehalo\Nanoid\Client;
use Illuminate\Support\Str as BaseStr;
use Illuminate\Support\Facades\File;

class Str extends BaseStr
{

    /**
     * @see https://zelark.github.io/nano-id-cc/
     */
    public static function nanoId(): string
    {
        $alphabet = config('app.nanoid.alphabet', '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
        $length = config('app.nanoid.length', 30);
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
        $options = array_merge($options, [
            'file_path' => resource_path('dictionary.txt'),
            'words' => 4,
            'delimiter' => '-',
            'min_char_length' => 5,
        ]);
        $contents = File::get($options['file_path']);
        return collect(explode(PHP_EOL, $contents))
            ->filter(function ($word) use ($options) {
                return $word >= $options['min_char_length'];
            })
            ->random($options['words'])
            ->implode($options['delimiter']);
    }
}
