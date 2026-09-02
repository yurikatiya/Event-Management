<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_gallery_index(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.gallery.index'))
            ->assertOk()
            ->assertSee('Gallery');
    }

    public function test_admin_can_create_gallery_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.gallery.store'), [
                'title' => 'R27 Event Photo',
                'description' => 'Event description',
                'status' => 'published',
                'image' => UploadedFile::fake()->create('gallery.jpg', 100, 'image/jpeg'),
            ])
            ->assertRedirect(route('admin.gallery.index'))
            ->assertSessionHas('success', 'Foto berhasil ditambahkan.');

        $this->assertDatabaseHas('galleries', [
            'title' => 'R27 Event Photo',
            'status' => 'published',
        ]);
    }

    public function test_root_redirects_to_login_page(): void
    {
        Storage::fake('public');

        Gallery::create([
            'title' => 'Featured Photo',
            'description' => 'Visible on landing page',
            'status' => 'published',
            'file_path' => 'gallery/featured.jpg',
        ]);

        $this->get('/')
            ->assertRedirect('/login');
    }
}
