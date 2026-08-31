<?php

namespace Tests\Feature;

use App\Models\Sponsor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SponsorManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_sponsors_index(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        Sponsor::create([
            'name' => 'R27 Partner',
            'tier' => 'Gold',
            'status' => 'active',
            'logo' => 'sponsors/test.png',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.sponsors.index'))
            ->assertOk()
            ->assertSee('Sponsors')
            ->assertSee('R27 Partner');
    }

    public function test_admin_can_create_sponsor(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.sponsors.store'), [
                'name' => 'Telkom Indonesia',
                'tier' => 'Platinum',
                'status' => 'active',
                'description' => 'Telecommunication partner',
            ])
            ->assertRedirect(route('admin.sponsors.index'))
            ->assertSessionHas('success', 'Sponsor berhasil ditambahkan.');

        $this->assertDatabaseHas('sponsors', [
            'name' => 'Telkom Indonesia',
            'tier' => 'Platinum',
            'status' => 'active',
        ]);
    }

    public function test_active_sponsor_appears_on_landing_page(): void
    {
        Sponsor::create([
            'name' => 'Bank BNI',
            'tier' => 'Gold',
            'status' => 'active',
            'logo' => 'sponsors/bni.png',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Bank BNI');
    }
}
