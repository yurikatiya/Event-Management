<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_renders_with_database_metrics(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard')
            ->assertSee('Selamat datang kembali, Admin. Ini ringkasan hari ini.')
            ->assertSee('Total Events')
            ->assertSee('Total Tim')
            ->assertSee('Sponsor Aktif')
            ->assertSee('Total Gallery')
            ->assertSee('Tech Summit 2026')
            ->assertSee('Sponsor Teratas')
            ->assertSee('Ringkasan Konten')
            ->assertSee('Aktivitas Terkini');
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    }
}