<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CategoryManagementTest extends TestCase
{
    use RefreshDatabase;

    private function signInAsAdmin(): User
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        $this->actingAs($admin);

        return $admin;
    }

    public function test_admin_can_create_update_and_delete_category(): void
    {
        $this->signInAsAdmin();

        $this->post(route('admin.categories.store'), [
            'name' => 'Workshop',
            'description' => 'Workshop and training events.',
        ])->assertRedirect(route('admin.categories.index'));

        $category = Category::where('name', 'Workshop')->firstOrFail();

        $this->put(route('admin.categories.update', $category), [
            'name' => 'Training',
            'description' => 'Updated description.',
        ])->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories', ['name' => 'Training']);

        $this->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_category_name_is_required_and_unique(): void
    {
        $this->signInAsAdmin();
        Category::create(['name' => 'Conference']);

        $this->from(route('admin.categories.create'))
            ->post(route('admin.categories.store'), ['name' => 'Conference'])
            ->assertRedirect(route('admin.categories.create'))
            ->assertSessionHasErrors('name');
    }

    public function test_guest_cannot_access_category_management(): void
    {
        $this->get(route('admin.categories.index'))->assertRedirect(route('login'));
    }
}