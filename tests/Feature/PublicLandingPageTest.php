<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicLandingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_page_is_public_and_renders_landing_view(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('R27');
    }
}
