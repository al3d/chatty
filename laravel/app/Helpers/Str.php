<?php

namespace App\Helpers;

use Hidehalo\Nanoid\Client;
use Illuminate\Support\Str as BaseStr;

class Str extends BaseStr
{

    public static function nanoId(): string
    {
        // no 0,1,I,Z to prevent lookalikes; no F,U to prevent obscenities
        // https://zelark.github.io/nano-id-cc/
        $alphabet = '23456789ABCDEGHJKLMNPQRSTVWXY';
        $client = new Client();
        return $client->formatedId($alphabet, 20);
    }
}
