<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Public landing page should render successfully.
     */
    public function test_the_application_redirects_to_login_from_root(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }
}
