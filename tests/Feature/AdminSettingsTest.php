<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_settings_page(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin R27',
            'email' => 'admin@r27creative.com',
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.settings'))
            ->assertOk()
            ->assertSee('Profile Admin')
            ->assertSee('Change Password')
            ->assertSee('Website / Company Settings')
            ->assertSee('Notification Settings');
    }

    public function test_non_admin_cannot_access_settings_page(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)
            ->get(route('admin.settings'))
            ->assertForbidden();
    }

    public function test_admin_can_update_profile_and_company_settings(): void
    {
        $admin = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'role' => 'admin',
            'password' => Hash::make('secret123'),
        ]);

        $this->actingAs($admin)
            ->from(route('admin.settings'))
            ->post(route('admin.settings'), [
                'section' => 'profile',
                'name' => 'Updated Admin',
                'email' => 'updated@example.com',
            ])
            ->assertRedirect(route('admin.settings'))
            ->assertSessionHas('success', 'Pengaturan berhasil diperbarui.');

        $this->actingAs($admin)
            ->from(route('admin.settings'))
            ->post(route('admin.settings'), [
                'section' => 'company',
                'company_name' => 'R27 Creative',
                'company_email' => 'hello@r27creative.com',
                'company_phone' => '+628123456789',
                'company_address' => 'Jakarta, Indonesia',
                'company_description' => 'Creative event agency',
            ])
            ->assertRedirect(route('admin.settings'))
            ->assertSessionHas('success', 'Pengaturan berhasil diperbarui.');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'name' => 'Updated Admin',
            'email' => 'updated@example.com',
            'company_name' => 'R27 Creative',
            'company_email' => 'hello@r27creative.com',
            'company_phone' => '+628123456789',
            'company_address' => 'Jakarta, Indonesia',
            'company_description' => 'Creative event agency',
        ]);
    }

    public function test_admin_can_change_password_only_when_old_password_matches(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => Hash::make('secret123'),
        ]);

        $this->actingAs($admin)
            ->from(route('admin.settings'))
            ->post(route('admin.settings'), [
                'section' => 'password',
                'current_password' => 'wrong-password',
                'password' => 'newsecret123',
                'password_confirmation' => 'newsecret123',
            ])
            ->assertRedirect(route('admin.settings'))
            ->assertSessionHasErrors('current_password');

        $this->actingAs($admin)
            ->from(route('admin.settings'))
            ->post(route('admin.settings'), [
                'section' => 'password',
                'current_password' => 'secret123',
                'password' => 'newsecret123',
                'password_confirmation' => 'newsecret123',
            ])
            ->assertRedirect(route('admin.settings'))
            ->assertSessionHas('success', 'Pengaturan berhasil diperbarui.');

        $this->assertTrue(Hash::check('newsecret123', $admin->fresh()->password));
    }

    public function test_admin_can_toggle_dark_mode_preference(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'dark_mode' => false,
        ]);

        $this->actingAs($admin)
            ->from(route('admin.settings'))
            ->post(route('admin.settings'), [
                'section' => 'notification',
                'admin_notifications_enabled' => 1,
                'dark_mode' => 1,
            ])
            ->assertRedirect(route('admin.settings'))
            ->assertSessionHas('success', 'Pengaturan berhasil diperbarui.');

        $this->assertTrue($admin->fresh()->dark_mode);
    }
}
