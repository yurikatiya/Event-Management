<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_login_page(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    public function test_admin_user_can_login_and_redirect_to_admin_dashboard(): void
    {
        User::factory()->create([
            'name' => 'Admin R27',
            'username' => 'admin',
            'email' => 'admin@r27creative.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs(User::where('username', 'admin')->first());
    }

    public function test_participant_user_can_login_and_redirect_to_participant_dashboard(): void
    {
        User::factory()->create([
            'name' => 'Participant R27',
            'username' => 'participant',
            'email' => 'participant@r27creative.com',
            'password' => Hash::make('participant123'),
            'role' => 'participant',
        ]);

        $response = $this->post('/login', [
            'username' => 'participant',
            'password' => 'participant123',
        ]);

        $response->assertRedirect('/participant/dashboard');
        $this->assertAuthenticatedAs(User::where('username', 'participant')->first());
    }
}
