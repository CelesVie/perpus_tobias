<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_register_and_is_logged_in(): void
    {
        $response = $this->post('/register', [
            'name' => 'Sari Wulandari',
            'email' => 'sari@example.test',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
            'phone' => '081234567890',
        ]);

        $response->assertRedirect(route('member.dashboard'));
        $this->assertAuthenticated();

        $user = User::query()->where('email', 'sari@example.test')->firstOrFail();
        $this->assertSame(UserRole::Member, $user->role);
        $this->assertTrue($user->is_active);
    }

    public function test_registration_rejects_duplicate_email(): void
    {
        User::factory()->create(['email' => 'sari@example.test']);

        $this->post('/register', [
            'name' => 'Sari Lain',
            'email' => 'sari@example.test',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_member_can_login_and_logout(): void
    {
        $user = User::factory()->create(['password' => 'rahasia123']);

        $this->post('/login', ['email' => $user->email, 'password' => 'rahasia123'])
            ->assertRedirect(route('member.dashboard'));

        $this->assertAuthenticatedAs($user);

        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $user = User::factory()->create(['password' => 'rahasia123']);

        $this->post('/login', ['email' => $user->email, 'password' => 'salah'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_inactive_member_is_logged_out_by_role_middleware(): void
    {
        $user = User::factory()->inactive()->create();

        $this->actingAs($user)->get('/member/dashboard')->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_admin_lands_on_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $this->post('/login', ['email' => $admin->email, 'password' => 'password'])
            ->assertRedirect(route('admin.dashboard'));
    }
}
