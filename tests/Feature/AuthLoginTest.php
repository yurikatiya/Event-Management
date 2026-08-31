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

    public function test_user_can_login_with_email_and_redirect_to_participant_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'user@r27.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->post('/login', [
            'identifier' => 'user@r27.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/participant/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_can_login_with_identifier_and_redirect_to_dashboard(): void
    {
        $admin = User::factory()->create([
            'username' => 'dashboard-admin',
            'email' => 'dashboard-admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'identifier' => 'dashboard-admin',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($admin);
    }

    public function test_invalid_login_returns_validation_error_without_expired_page(): void
    {
        $response = $this->from('/login')->post('/login', [
            'identifier' => 'unknown@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('identifier');
        $this->assertGuest();
    }

    public function test_guest_can_register_and_is_redirected_to_login_page(): void
    {
        $response = $this->post('/register', [
            'name' => 'New User',
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/login');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'username' => 'newuser',
            'role' => 'user',
        ]);
    }
}
