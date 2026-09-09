<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_events_page_does_not_mark_history_as_active(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('events.index'));

        $html = $response->getContent();

        $this->assertSame(1, substr_count($html, 'bg-slate-900 text-white'));
        $response->assertSee('Eventos');
        $response->assertSee('Histórico');
    }

    public function test_history_page_has_its_own_navigation_state(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('events.history'));

        $html = $response->getContent();

        $this->assertSame(1, substr_count($html, 'bg-slate-900 text-white'));
        $response->assertSee('Histórico');
        $response->assertSee('Nenhum evento no histórico.');
    }

    public function test_admin_navigation_still_has_only_one_active_item(): void
    {
        $admin = User::factory()->create([
            'role' => UserRole::Admin,
        ]);

        $response = $this->actingAs($admin)->get(route('users.index'));

        $this->assertSame(1, substr_count($response->getContent(), 'bg-slate-900 text-white'));
        $response->assertSee('Admin');
    }
}
