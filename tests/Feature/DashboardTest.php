<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\DashboardCalendarNote;
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
            'start_date' => today()->subMonth()->toDateString(),
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
            ->assertSee('Halo, ' . $admin->name . '!')
            ->assertSee('Berikut ringkasan aktivitas hari ini.')
            ->assertSee('data-dashboard-calendar', false)
            ->assertSee('role="dialog" aria-labelledby="calendar-note-title"', false)
            ->assertSee('data-year="' . now()->year . '"', false)
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
            ->assertSee('Ringkasan Event Bulanan')
            ->assertSee('Event berlangsung per bulan')
            ->assertSee('data-year="' . $event->start_date->year . '"', false)
            ->assertSee('data-month="' . $event->start_date->month . '" data-count="1"', false)
            ->assertSee('Aktivitas Terkini');
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_monthly_event_chart_navigates_between_years_with_events(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::create(['name' => 'Chart Fixture Category']);

        foreach ([2023 => '2023-03-15', 2024 => '2024-08-20'] as $year => $date) {
            Event::create([
                'category_id' => $category->id,
                'created_by' => $admin->id,
                'name' => "Chart Event {$year}",
                'description' => 'Event untuk tes navigasi grafik tahunan.',
                'start_date' => $date,
                'location' => 'Test Venue',
                'status' => 'published',
            ]);
        }

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('data-chart-year="2024"', false)
            ->assertSee('data-month="8" data-count="1"', false)
            ->assertSee(route('admin.dashboard', ['chart_year' => 2023]), false);

        $this->get(route('admin.dashboard', ['chart_year' => 2023]))
            ->assertOk()
            ->assertSee('data-chart-year="2023"', false)
            ->assertSee('data-month="3" data-count="1"', false)
            ->assertSee(route('admin.dashboard', ['chart_year' => 2024]), false);
    }

    public function test_admin_can_create_update_and_delete_calendar_notes_for_current_year(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $date = now()->startOfYear()->addDays(10)->toDateString();
        $route = route('admin.dashboard.calendar-notes.store');

        $this->actingAs($admin)
            ->postJson($route, ['date' => $date, 'note' => 'Prepare launch'])
            ->assertOk()
            ->assertJsonPath('note', 'Prepare launch');

        $this->postJson($route, ['date' => $date, 'note' => 'Updated launch plan'])
            ->assertOk()
            ->assertJsonPath('note', 'Updated launch plan');

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Updated launch plan');

        $this->assertDatabaseCount('dashboard_calendar_notes', 1);
        $this->assertSame(
            'Updated launch plan',
            DashboardCalendarNote::query()
                ->where('user_id', $admin->id)
                ->whereDate('note_date', $date)
                ->value('note'),
        );

        $this->deleteJson(route('admin.dashboard.calendar-notes.destroy'), ['date' => $date])
            ->assertOk()
            ->assertJsonPath('deleted', true);

        $this->assertSame(
            0,
            DashboardCalendarNote::query()
                ->where('user_id', $admin->id)
                ->whereDate('note_date', $date)
                ->count(),
        );
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