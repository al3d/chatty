<?php

namespace App\Support;

use Illuminate\Support\Facades\Config;

class Url
{

    public static function frontend($url = '')
    {
        return rtrim(Config::get('app.frontend_url') . $url, '/');
    }
}
