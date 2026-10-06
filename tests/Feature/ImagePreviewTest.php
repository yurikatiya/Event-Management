<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Sponsor;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImagePreviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_image_create_forms_render_their_preview_controls(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        foreach ([
            'admin.events.create',
            'admin.sponsors.create',
            'admin.partners.create',
            'admin.services.create',
            'admin.teams.create',
        ] as $routeName) {
            $this->get(route($routeName))
                ->assertOk()
                ->assertSee('data-image-preview', false)
                ->assertSee('data-image-preview-target', false);
        }

        $this->get(route('admin.gallery.create'))
            ->assertOk()
            ->assertSee('data-gallery-files', false)
            ->assertSee('data-gallery-preview', false);
    }

    public function test_all_image_edit_forms_render_the_saved_image_preview(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::create(['name' => 'Image Preview']);
        $event = Event::create([
            'category_id' => $category->id,
            'created_by' => $admin->id,
            'name' => 'Image Preview Event',
            'description' => 'Event with a saved cover image.',
            'start_date' => '2026-10-06',
            'location' => 'Jakarta',
            'poster' => 'events/cover.jpg',
            'status' => 'published',
        ]);
        $gallery = Gallery::create([
            'event_id' => $event->id,
            'title' => $event->name,
            'file_path' => 'gallery/photo.jpg',
            'status' => 'published',
        ]);
        $sponsor = Sponsor::create([
            'name' => 'Image Preview Sponsor',
            'tier' => 'Gold',
            'status' => 'active',
            'logo' => 'sponsors/logo.jpg',
        ]);
        $partner = Partner::create([
            'name' => 'Image Preview Partner',
            'category' => 'Company',
            'status' => 'published',
            'logo' => 'partners/logo.jpg',
        ]);
        $service = Service::create([
            'name' => 'Image Preview Service',
            'description' => 'Service with an image.',
            'status' => 'published',
            'image' => 'services/image.jpg',
        ]);
        $team = Team::create([
            'name' => 'Image Preview Team',
            'position' => 'Member',
            'status' => 'published',
            'photo' => 'teams/photo.jpg',
        ]);

        $this->actingAs($admin);

        foreach ([
            route('admin.events.edit', $event),
            route('admin.sponsors.edit', $sponsor),
            route('admin.partners.edit', $partner),
            route('admin.services.edit', $service),
            route('admin.teams.edit', $team),
        ] as $url) {
            $this->get($url)
                ->assertOk()
                ->assertSee('data-image-preview-target', false);
        }

        $this->get(route('admin.gallery.edit', $gallery))
            ->assertOk()
            ->assertSee('data-image-preview-target-for="image"', false);
    }

    public function test_team_without_a_photo_can_be_deleted_without_a_storage_error(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $team = Team::create([
            'name' => 'Team without a photo',
            'position' => 'Member',
            'status' => 'draft',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.teams.destroy', $team))
            ->assertRedirect(route('admin.teams.index'));

        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    }
}
