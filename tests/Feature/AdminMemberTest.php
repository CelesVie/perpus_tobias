<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminMemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_member_from_the_panel(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get('/admin/members/create')
            ->assertOk()
            ->assertSee('Tambah anggota');

        $response = $this->actingAs($admin)->post('/admin/members', [
            'name' => '  Nadia Pratama  ',
            'email' => 'Nadia.Pratama@Example.TEST',
            'phone' => '081234567890',
            'password' => 'rahasia-anggota',
            'password_confirmation' => 'rahasia-anggota',
        ]);

        $member = User::query()->where('email', 'nadia.pratama@example.test')->firstOrFail();

        $response->assertRedirect(route('admin.members.show', $member))
            ->assertSessionHas('status', 'Akun anggota berhasil ditambahkan.');

        $this->assertSame('Nadia Pratama', $member->name);
        $this->assertSame(UserRole::Member, $member->role);
        $this->assertTrue($member->is_active);
        $this->assertNotNull($member->email_verified_at);
        $this->assertNotNull($member->joined_at);
        $this->assertNotSame('rahasia-anggota', $member->password);
        $this->assertTrue(Hash::check('rahasia-anggota', $member->password));
        $this->assertDatabaseHas('activity_logs', ['action' => 'member.created']);

        $this->actingAs($admin)->get('/admin/members')
            ->assertOk()
            ->assertSee('Nadia Pratama');
    }

    public function test_store_member_validates_unique_email_and_password_confirmation(): void
    {
        $admin = User::factory()->admin()->create();
        User::factory()->create(['email' => 'sudah.ada@example.test']);

        $this->actingAs($admin)->post('/admin/members', [
            'name' => 'Anggota Baru',
            'email' => 'SUDAH.ADA@example.test',
            'password' => 'rahasia-anggota',
            'password_confirmation' => 'rahasia-anggota',
        ])->assertSessionHasErrors('email');

        $this->actingAs($admin)->post('/admin/members', [
            'name' => 'Anggota Baru',
            'email' => 'anggota.baru@example.test',
            'password' => 'rahasia-anggota',
            'password_confirmation' => 'beda-sendiri',
        ])->assertSessionHasErrors('password');

        $this->assertDatabaseMissing('users', ['email' => 'anggota.baru@example.test']);
    }

    public function test_member_cannot_open_the_member_create_page(): void
    {
        $member = User::factory()->create();

        $this->actingAs($member)->get('/admin/members/create')->assertForbidden();
        $this->actingAs($member)->post('/admin/members', [])->assertForbidden();

        $this->assertSame(0, ActivityLog::query()->where('action', 'member.created')->count());
    }

    public function test_guest_is_redirected_to_login_from_the_member_create_page(): void
    {
        $this->get('/admin/members/create')->assertRedirect(route('login'));
        $this->post('/admin/members', [])->assertRedirect(route('login'));
    }
}
