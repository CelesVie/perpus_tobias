<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateAdminCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_admin_command_creates_a_hashed_admin_account(): void
    {
        $this->artisan('app:create-admin')
            ->expectsQuestion('Nama lengkap', 'Sari Pustakawan')
            ->expectsQuestion('Email', 'Sari.Pustakawan@Example.test')
            ->expectsQuestion('Kata sandi (minimal 8 karakter)', 'rahasia-admin')
            ->expectsQuestion('Ulangi kata sandi', 'rahasia-admin')
            ->assertSuccessful();

        $admin = User::query()->where('email', 'sari.pustakawan@example.test')->firstOrFail();

        $this->assertSame('Sari Pustakawan', $admin->name);
        $this->assertSame(UserRole::Admin, $admin->role);
        $this->assertTrue($admin->is_active);
        $this->assertNotNull($admin->email_verified_at);
        $this->assertNotNull($admin->joined_at);
        $this->assertNotSame('rahasia-admin', $admin->password);
        $this->assertTrue(Hash::check('rahasia-admin', $admin->password));
    }
}
