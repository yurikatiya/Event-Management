<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\Category;
use App\Models\Event;
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

    public function test_admin_can_open_an_album_form_for_an_event(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $event = $this->createEvent($admin, 'Seminar Sangkuriang');

        $this->actingAs($admin)
            ->get(route('admin.gallery.create'))
            ->assertOk()
            ->assertSee($event->name)
            ->assertSee('Buat album')
            ->assertSee('name="images[]"', false)
            ->assertSee('multiple', false)
            ->assertSee('Status album');
    }

    public function test_admin_can_add_photos_directly_to_an_existing_event_album(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $event = $this->createEvent($admin, 'Seminar Sangkuriang');
        Gallery::create([
            'event_id' => $event->id,
            'title' => $event->name,
            'caption' => 'existing-photo.jpg',
            'status' => 'published',
            'file_path' => 'gallery/events/' . $event->id . '/existing-photo.jpg',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.gallery.create', ['event_id' => $event->id]))
            ->assertOk()
            ->assertSee('Tambah foto')
            ->assertSee('Foto baru akan langsung ditambahkan ke album Seminar Sangkuriang.')
            ->assertSee('name="event_id" value="' . $event->id . '"', false)
            ->assertDontSee('role="combobox"', false)
            ->assertSee('Keterangan foto')
            ->assertSee('Status foto');

        $this->post(route('admin.gallery.store'), [
            'event_id' => $event->id,
            'status' => 'published',
            'images' => [UploadedFile::fake()->create('additional-photo.jpg', 100, 'image/jpeg')],
        ])
            ->assertRedirect(route('admin.gallery.index', ['album' => 'event-' . $event->id]))
            ->assertSessionHas('success', '1 foto berhasil ditambahkan ke album Seminar Sangkuriang.');

        $this->assertDatabaseCount('galleries', 2);
        $this->assertDatabaseHas('galleries', [
            'event_id' => $event->id,
            'caption' => 'additional-photo.jpg',
            'status' => 'published',
        ]);
    }

    public function test_admin_can_create_an_event_album_with_multiple_photos(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $event = $this->createEvent($admin, 'Seminar Sangkuriang');

        $this->actingAs($admin)
            ->post(route('admin.gallery.store'), [
                'event_id' => $event->id,
                'description' => 'Event description',
                'status' => 'published',
                'images' => [
                    UploadedFile::fake()->create('sangkuriang-1.jpg', 100, 'image/jpeg'),
                    UploadedFile::fake()->create('sangkuriang-2.jpg', 100, 'image/jpeg'),
                ],
            ])
            ->assertRedirect(route('admin.gallery.index', ['album' => 'event-' . $event->id]))
            ->assertSessionHas('success', '2 foto berhasil ditambahkan ke album Seminar Sangkuriang.');

        $this->assertDatabaseCount('galleries', 2);
        $this->assertDatabaseHas('galleries', [
            'event_id' => $event->id,
            'title' => 'Seminar Sangkuriang',
            'caption' => 'sangkuriang-1.jpg',
            'status' => 'published',
        ]);

        $firstPhoto = Gallery::query()->where('event_id', $event->id)->firstOrFail();
        Storage::disk('public')->assertExists($firstPhoto->file_path);
        $this->get(route('admin.events.index'))
            ->assertOk()
            ->assertSee('2 foto')
            ->assertSee(asset('storage/' . $firstPhoto->file_path), false)
            ->assertSee(route('admin.gallery.index', ['search' => $event->name]), false);
    }

    public function test_gallery_upload_rejects_photos_over_two_megabytes_with_a_modern_alert(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $event = $this->createEvent($admin, 'Seminar Sangkuriang');

        $this->actingAs($admin)
            ->from(route('admin.gallery.create'))
            ->followingRedirects()
            ->post(route('admin.gallery.store'), [
                'event_id' => $event->id,
                'status' => 'published',
                'images' => [UploadedFile::fake()->createWithContent(
                    'too-large.png',
                    base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/ylcAAAAASUVORK5CYII=') . str_repeat('0', 2 * 1024 * 1024),
                )],
            ])
            ->assertOk()
            ->assertSee('Upload gagal')
            ->assertSee('Ukuran setiap foto maksimal 2 MB.');

        $this->assertDatabaseCount('galleries', 0);
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_gallery_index_groups_photos_by_event_album(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $event = $this->createEvent($admin, 'Seminar Sangkuriang');

        foreach (['sangkuriang-1.jpg', 'sangkuriang-2.jpg'] as $filename) {
            Gallery::create([
                'event_id' => $event->id,
                'title' => $event->name,
                'caption' => $filename,
                'status' => 'published',
                'file_path' => 'gallery/' . $filename,
            ]);
        }

        $this->actingAs($admin)
            ->get(route('admin.gallery.index'))
            ->assertOk()
            ->assertSee('Seminar Sangkuriang')
            ->assertSee('2 foto');
    }

    public function test_root_redirects_to_login_page(): void
    {
        Storage::fake('public');

        Gallery::create([
            'title' => 'Featured Photo',
            'description' => 'Visible in admin gallery',
            'status' => 'published',
            'file_path' => 'gallery/featured.jpg',
        ]);

        $this->get('/')
            ->assertRedirect('/login');
    }

    private function createEvent(User $admin, string $name): Event
    {
        $category = Category::create(['name' => 'Gallery Test Category']);

        return Event::create([
            'category_id' => $category->id,
            'created_by' => $admin->id,
            'name' => $name,
            'description' => 'Event used by the gallery feature tests.',
            'start_date' => today()->toDateString(),
            'location' => 'Test Venue',
            'status' => 'published',
        ]);
    }
}
