<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MiscTest extends TestCase
{
    public function testFallback()
    {
        $response = $this->get('/unknown');

        $response->assertStatus(301);
    }
}
