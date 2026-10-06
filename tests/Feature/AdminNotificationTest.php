<?php

namespace Tests\Feature;

use App\Models\AdminNotification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_content_changes_create_notifications_for_enabled_admins(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'admin_notifications_enabled' => true]);
        $anotherAdmin = User::factory()->create(['role' => 'admin', 'admin_notifications_enabled' => true]);
        User::factory()->create(['role' => 'user']);

        $this->actingAs($admin)
            ->post(route('admin.categories.store'), [
                'name' => 'Konferensi',
                'description' => 'Acara konferensi',
            ])
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseCount('admin_notifications', 2);
        $this->assertDatabaseHas('admin_notifications', [
            'user_id' => $admin->id,
            'actor_id' => $admin->id,
            'entity' => 'category',
            'action' => 'created',
            'title' => 'Category baru ditambahkan',
        ]);
        $this->assertDatabaseHas('admin_notifications', [
            'user_id' => $anotherAdmin->id,
            'entity' => 'category',
        ]);
    }

    public function test_admin_can_list_and_mark_only_their_notifications_as_read(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'admin_notifications_enabled' => true]);
        $otherAdmin = User::factory()->create(['role' => 'admin', 'admin_notifications_enabled' => true]);
        $notification = AdminNotification::create([
            'user_id' => $admin->id,
            'actor_id' => $otherAdmin->id,
            'entity' => 'category',
            'action' => 'created',
            'title' => 'Category baru ditambahkan',
            'message' => 'Admin menambahkan Category: Konferensi.',
            'url' => route('admin.categories.index'),
        ]);
        $otherNotification = AdminNotification::create([
            'user_id' => $otherAdmin->id,
            'actor_id' => $admin->id,
            'entity' => 'event',
            'action' => 'created',
            'title' => 'Event baru ditambahkan',
            'message' => 'Admin menambahkan Event: Acara.',
            'url' => route('admin.events.index'),
        ]);

        $this->actingAs($admin)
            ->getJson(route('admin.notifications.index'))
            ->assertOk()
            ->assertJsonPath('unread_count', 1)
            ->assertJsonPath('items.0.title', 'Category baru ditambahkan');

        $this->actingAs($admin)
            ->patch(route('admin.notifications.read', $notification))
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertNotNull($notification->fresh()->read_at);
        $this->assertNull($otherNotification->fresh()->read_at);

        $this->actingAs($admin)
            ->patch(route('admin.notifications.read', $otherNotification))
            ->assertNotFound();
    }

    public function test_disabled_admin_notifications_are_not_created_or_returned(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'admin_notifications_enabled' => false,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.categories.store'), [
                'name' => 'Workshop',
                'description' => 'Lokakarya',
            ])
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseMissing('admin_notifications', ['user_id' => $admin->id]);

        $this->getJson(route('admin.notifications.index'))
            ->assertOk()
            ->assertJsonPath('enabled', false)
            ->assertJsonPath('items', []);
    }
}
