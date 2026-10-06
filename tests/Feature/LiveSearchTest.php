<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LiveSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_index_pages_expose_live_search_and_replaceable_results(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        foreach ([
            'admin.events.index',
            'admin.categories.index',
            'admin.sponsors.index',
            'admin.partners.index',
            'admin.services.index',
            'admin.teams.index',
            'admin.gallery.index',
        ] as $routeName) {
            $this->get(route($routeName))
                ->assertOk()
                ->assertSee('data-live-search', false)
                ->assertSee('data-live-search-results', false)
                ->assertSee('data-live-search-summary', false);
        }
    }

    public function test_gallery_album_index_exposes_individual_photo_viewer_and_actions(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::create(['name' => 'Gallery Test']);
        $event = Event::create([
            'category_id' => $category->id,
            'created_by' => $admin->id,
            'name' => 'Album Test',
            'description' => 'Event for gallery preview.',
            'start_date' => '2026-10-06',
            'location' => 'Jakarta',
            'status' => 'published',
        ]);
        Gallery::create([
            'event_id' => $event->id,
            'title' => $event->name,
            'caption' => 'Test photo',
            'file_path' => 'gallery/test.jpg',
            'status' => 'published',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.gallery.index'))
            ->assertOk()
            ->assertSee('Lihat semua foto')
            ->assertDontSee('class="gallery-photo-grid" data-gallery-photo-grid', false)
            ->assertDontSee('aria-label="Lihat Test photo"', false);

        $this->get(route('admin.gallery.index', ['album' => 'event-' . $event->id]))
            ->assertOk()
            ->assertSee('aria-label="Foto dalam album Album Test"', false)
            ->assertSee('data-gallery-lightbox', false)
            ->assertSee('Foto sebelumnya')
            ->assertSee('Foto berikutnya')
            ->assertSee('Edit foto')
            ->assertSee('Hapus foto')
            ->assertSee('aria-label="Tambah foto"', false)
            ->assertSee('M12 5v14M5 12h14', false);
    }
}
