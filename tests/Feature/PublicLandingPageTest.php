<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicLandingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_login_page(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }
}
