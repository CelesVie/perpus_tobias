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

    public function test_admin_can_update_a_member_without_touching_the_password(): void
    {
        $admin = User::factory()->admin()->create();
        $member = User::factory()->create([
            'name' => 'Nama Lama',
            'email' => 'lama@example.test',
            'password' => 'password-lama',
        ]);

        $this->actingAs($admin)->get('/admin/members/'.$member->id.'/edit')
            ->assertOk()
            ->assertSee('Ubah data anggota')
            ->assertSee('Kosongkan jika tidak ingin mengubah kata sandi.');

        // Email dibiarkan sama: validasi unique harus mengabaikan baris ini sendiri.
        $this->actingAs($admin)->put('/admin/members/'.$member->id, [
            'name' => 'Nama Baru',
            'email' => 'lama@example.test',
            'phone' => '081200000000',
            'address' => 'Jl. Baru No. 1',
        ])->assertRedirect(route('admin.members.show', $member))
            ->assertSessionHas('status', 'Data anggota berhasil diperbarui.');

        $member->refresh();

        $this->assertSame('Nama Baru', $member->name);
        $this->assertSame('lama@example.test', $member->email);
        $this->assertSame('081200000000', $member->phone);
        $this->assertSame('Jl. Baru No. 1', $member->address);
        $this->assertTrue(Hash::check('password-lama', $member->password));

        $this->actingAs($admin)->patch('/admin/members/'.$member->id, [
            'name' => 'Nama Baru',
            'email' => 'BARU@Example.TEST',
        ])->assertRedirect(route('admin.members.show', $member));

        $this->assertSame('baru@example.test', $member->fresh()->email);
        $this->assertSame(UserRole::Member, $member->fresh()->role);
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'member.updated',
            'subject_id' => $member->id,
        ]);
    }

    public function test_admin_can_replace_a_member_password(): void
    {
        $admin = User::factory()->admin()->create();
        $member = User::factory()->create([
            'email' => 'ganti@example.test',
            'password' => 'password-lama',
        ]);

        $this->actingAs($admin)->put('/admin/members/'.$member->id, [
            'name' => $member->name,
            'email' => $member->email,
            'password' => 'password-baru',
            'password_confirmation' => 'password-baru',
        ])->assertRedirect(route('admin.members.show', $member));

        $member->refresh();

        $this->assertTrue(Hash::check('password-baru', $member->password));
        $this->assertFalse(Hash::check('password-lama', $member->password));
    }

    public function test_update_member_validates_email_conflict_and_password_confirmation(): void
    {
        $admin = User::factory()->admin()->create();
        $member = User::factory()->create(['email' => 'anggota@example.test']);
        User::factory()->create(['email' => 'lain@example.test']);

        $this->actingAs($admin)->put('/admin/members/'.$member->id, [
            'name' => $member->name,
            'email' => 'lain@example.test',
        ])->assertSessionHasErrors('email');

        $this->actingAs($admin)->put('/admin/members/'.$member->id, [
            'name' => $member->name,
            'email' => $member->email,
            'password' => 'password-baru',
            'password_confirmation' => 'beda-sendiri',
        ])->assertSessionHasErrors('password');

        $this->assertSame('anggota@example.test', $member->fresh()->email);
    }

    public function test_admin_cannot_edit_another_admin_or_be_edited_by_a_member(): void
    {
        $admin = User::factory()->admin()->create();
        $otherAdmin = User::factory()->admin()->create();
        $member = User::factory()->create();

        $this->actingAs($admin)->get('/admin/members/'.$otherAdmin->id.'/edit')->assertNotFound();
        $this->actingAs($admin)->put('/admin/members/'.$otherAdmin->id, [
            'name' => 'Hacked',
            'email' => $otherAdmin->email,
        ])->assertNotFound();

        $this->actingAs($member)->get('/admin/members/'.$member->id.'/edit')->assertForbidden();
        $this->actingAs($member)->put('/admin/members/'.$member->id, [])->assertForbidden();

        $this->assertSame($otherAdmin->name, $otherAdmin->fresh()->name);
    }

    public function test_guest_is_redirected_to_login_from_the_member_edit_page(): void
    {
        $member = User::factory()->create();

        $this->get('/admin/members/'.$member->id.'/edit')->assertRedirect(route('login'));
        $this->put('/admin/members/'.$member->id, [])->assertRedirect(route('login'));
    }
}
