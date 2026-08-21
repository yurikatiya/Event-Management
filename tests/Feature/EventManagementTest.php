<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_update_and_delete_event(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::create(['name' => 'Creative']);
        $this->actingAs($admin);

        $this->post(route('admin.events.store'), [
            'category_id' => $category->id,
            'name' => 'R27 Creative Summit',
            'description' => 'A creative event for partners.',
            'start_date' => '2026-10-10',
            'start_time' => '09:00',
            'end_time' => '17:00',
            'location' => 'Jakarta',
            'address' => 'Sudirman Central',
            'organizer' => 'PT R27 Creative Agency',
            'status' => 'upcoming',
        ])->assertRedirect(route('admin.events.index'));

        $event = Event::where('name', 'R27 Creative Summit')->firstOrFail();
        $this->assertSame('upcoming', $event->status);
        $this->assertSame('09:00', $event->start_time);

        $this->put(route('admin.events.update', $event), [
            'category_id' => $category->id,
            'name' => 'R27 Creative Summit Updated',
            'description' => 'Updated event.',
            'start_date' => '2026-10-11',
            'location' => 'Bandung',
            'status' => 'completed',
        ])->assertRedirect(route('admin.events.index'));

        $this->assertDatabaseHas('events', ['name' => 'R27 Creative Summit Updated', 'status' => 'completed']);

        $this->delete(route('admin.events.destroy', $event))->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    public function test_event_list_can_search_and_filter_by_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::create(['name' => 'Launch']);
        Event::create(['category_id' => $category->id, 'created_by' => $admin->id, 'name' => 'Published Launch', 'description' => 'Published', 'start_date' => '2026-11-01', 'location' => 'Jakarta', 'status' => 'upcoming']);
        Event::create(['category_id' => $category->id, 'created_by' => $admin->id, 'name' => 'Draft Launch', 'description' => 'Draft', 'start_date' => '2026-11-02', 'location' => 'Jakarta', 'status' => 'draft']);

        $this->actingAs($admin)->get(route('admin.events.index', ['search' => 'Published', 'status' => 'upcoming']))
            ->assertOk()
            ->assertSee('Published Launch')
            ->assertDontSee('Draft Launch');
    }

    public function test_events_page_uses_the_shared_admin_layout(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.events.index'));

        $response->assertOk()
            ->assertSee('R27 CMS')
            ->assertSee('Creative Event Management')
            ->assertSee('Event Management')
            ->assertSee('Events')
            ->assertDontSee('Admin Dashboard');
    }

    public function test_legacy_events_url_redirects_to_canonical_events_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/admin/events')
            ->assertRedirect('/events');
    }
}