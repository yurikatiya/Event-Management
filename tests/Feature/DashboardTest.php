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

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_renders_with_database_metrics(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::create(['name' => 'Dashboard Fixture Category']);
        $event = Event::create([
            'category_id' => $category->id,
            'created_by' => $admin->id,
            'name' => 'Dashboard Fixture Event',
            'description' => 'A real event used by the dashboard feature test.',
            'start_date' => today()->addWeek()->toDateString(),
            'location' => 'Test Venue',
            'status' => 'published',
        ]);
        $sponsor = Sponsor::create([
            'name' => 'Dashboard Fixture Sponsor',
            'status' => 'active',
            'tier' => 'Gold',
        ]);
        $event->sponsors()->attach($sponsor);
        Team::create(['name' => 'Dashboard Fixture Team', 'position' => 'Coordinator', 'status' => 'published']);
        Gallery::create([
            'event_id' => $event->id,
            'file_path' => 'dashboard-fixture.jpg',
            'caption' => 'Dashboard Fixture Gallery',
        ]);
        Partner::create([
            'name' => 'Dashboard Fixture Partner',
            'category' => 'Company',
            'status' => 'published',
        ]);
        Service::create([
            'name' => 'Dashboard Fixture Service',
            'description' => 'A real service used by the dashboard feature test.',
            'status' => 'published',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard')
            ->assertSee('Events')
            ->assertSee('Categories')
            ->assertSee('Sponsors')
            ->assertSee('Partners')
            ->assertSee('Teams')
            ->assertSee('Gallery')
            ->assertSee('Setting')
            ->assertSee('Selamat datang kembali, ' . $admin->name . '. Ini ringkasan hari ini.')
            ->assertSee('Total Events')
            ->assertSee('Total Tim')
            ->assertSee('Sponsor Aktif')
            ->assertSee('Total Gallery')
            ->assertSee('Dashboard Fixture Event')
            ->assertSee('Dashboard Fixture Category')
            ->assertSee('Dashboard Fixture Team')
            ->assertSee('Dashboard Fixture Sponsor')
            ->assertSee('Dashboard Fixture Gallery')
            ->assertSee('Dashboard Fixture Partner')
            ->assertSee('Gold')
            ->assertDontSee('Tech Summit 2026')
            ->assertSee('Sponsor Teratas')
            ->assertSee('Ringkasan Konten')
            ->assertSee('Aktivitas Terkini');
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_dashboard_shows_empty_states_when_database_has_no_content(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Belum ada event di database.')
            ->assertSee('Belum ada sponsor di database.')
            ->assertSee('Belum ada aktivitas untuk ditampilkan.')
            ->assertDontSee('Tech Summit 2026');
    }
}