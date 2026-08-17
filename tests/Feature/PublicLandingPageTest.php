<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicLandingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_access_public_landing_page(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Create. Connect. Experience.');
        $response->assertSee('Sign In');
        $response->assertSee('Sign Up');
    }

    public function test_homepage_only_shows_approved_events(): void
    {
        $category = Category::create([
            'name' => 'Technology',
            'description' => 'Technology events',
        ]);

        $approvedUser = \App\Models\User::factory()->create([
            'username' => 'approvedcreator',
            'role' => 'participant',
        ]);

        Event::create([
            'category_id' => $category->id,
            'created_by' => $approvedUser->id,
            'name' => 'Approved Event',
            'description' => 'This event is approved and should appear.',
            'start_date' => '2026-09-10',
            'end_date' => '2026-09-12',
            'location' => 'Jakarta',
            'quota' => 120,
            'poster' => null,
            'status' => 'approved',
            'approved_by' => $approvedUser->id,
        ]);

        Event::create([
            'category_id' => $category->id,
            'created_by' => $approvedUser->id,
            'name' => 'Pending Event',
            'description' => 'This event should not appear on homepage.',
            'start_date' => '2026-09-20',
            'end_date' => '2026-09-21',
            'location' => 'Bandung',
            'quota' => 80,
            'poster' => null,
            'status' => 'pending',
            'approved_by' => null,
        ]);

        Event::create([
            'category_id' => $category->id,
            'created_by' => $approvedUser->id,
            'name' => 'Rejected Event',
            'description' => 'This event should not appear on homepage.',
            'start_date' => '2026-09-30',
            'end_date' => '2026-10-01',
            'location' => 'Surabaya',
            'quota' => 50,
            'poster' => null,
            'status' => 'rejected',
            'rejection_reason' => 'Not suitable',
            'approved_by' => null,
        ]);

        $response = $this->get('/');

        $response->assertSee('Approved Event');
        $response->assertDontSee('Pending Event');
        $response->assertDontSee('Rejected Event');
    }
}
