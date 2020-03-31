<?php

namespace Tests\Feature\App\Support;

use App\Support\Url;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class UrlTest extends TestCase
{

    public function testDefaultFrontendUrl()
    {
        $frontendUrl = 'http://www.example.com';
        Config::set('app.frontend_url', $frontendUrl);

        $this->assertEquals(Url::frontend(), $frontendUrl);
        $this->assertEquals(Url::frontend('///'), $frontendUrl);
        $url = $frontendUrl . '/test';
        $this->assertEquals(Url::frontend('/test'), $url);
    }
}
