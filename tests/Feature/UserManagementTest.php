<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_team_member(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('users.store'), [
            'name' => 'Lucas Tecnico',
            'email' => 'lucas@ppproducoes.com',
            'role' => UserRole::Team->value,
            'password' => 'password',
            'password_confirmation' => 'password',
            'active' => '1',
        ]);

        $response->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'name' => 'Lucas Tecnico',
            'email' => 'lucas@ppproducoes.com',
            'role' => UserRole::Team->value,
            'active' => true,
        ]);
    }

    public function test_team_member_cannot_access_user_management(): void
    {
        $teamMember = User::factory()->create();

        $response = $this->actingAs($teamMember)->get(route('users.index'));

        $response->assertForbidden();
    }

    public function test_inactive_user_cannot_login(): void
    {
        User::factory()->inactive()->create([
            'email' => 'inativo@ppproducoes.com',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'inativo@ppproducoes.com',
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }
}
