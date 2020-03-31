<?php

namespace App\Support;

class Url
{

    public static function frontend($url = '')
    {
        return rtrim(config('app.frontend_url'), '/') . $url;
    }
}
