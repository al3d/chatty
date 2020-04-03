<?php

namespace Tests\Feature;

use Tests\TestCase;

class WebRoutesTest extends TestCase
{
    public function testFallback()
    {
        $response = $this->get('/unknown');

        $response->assertStatus(301);
    }
}
