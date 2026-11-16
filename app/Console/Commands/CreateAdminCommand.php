<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Closure;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

#[Signature('app:create-admin')]
#[Description('Membuat akun pustakawan (admin) baru secara interaktif.')]
class CreateAdminCommand extends Command
{
    public function handle(): int
    {
        $this->info('Membuat akun pustakawan (admin) baru.');

        $name = $this->askValid('Nama lengkap', 'name', ['required', 'string', 'max:80']);
        $email = $this->askValid(
            'Email',
            'email',
            ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            fn (string $value): string => Str::lower($value)
        );
        $password = $this->askPassword();

        $admin = User::query()->forceCreate([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => UserRole::Admin,
            'is_active' => true,
            'email_verified_at' => now(),
            'joined_at' => now(),
        ]);

        $this->newLine();
        $this->info("Akun pustakawan dibuat: {$admin->name} <{$admin->email}>");

        return self::SUCCESS;
    }

    /**
     * Tanya satu input sampai lolos validasi.
     *
     * @param  array<int, mixed>  $rules
     */
    private function askValid(string $label, string $field, array $rules, ?Closure $normalize = null): string
    {
        while (true) {
            $value = trim((string) $this->ask($label));

            if ($normalize !== null) {
                $value = $normalize($value);
            }

            $validator = Validator::make([$field => $value], [$field => $rules]);

            if ($validator->passes()) {
                return $value;
            }

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
        }
    }

    /**
     * Minta kata sandi dua kali sampai cocok dan memenuhi aturan minimal.
     */
    private function askPassword(): string
    {
        while (true) {
            $password = (string) $this->secret('Kata sandi (minimal 8 karakter)');
            $confirmation = (string) $this->secret('Ulangi kata sandi');

            if ($password !== $confirmation) {
                $this->error('Konfirmasi kata sandi tidak cocok.');

                continue;
            }

            $validator = Validator::make(
                ['password' => $password],
                ['password' => ['required', 'string', Password::min(8)]]
            );

            if ($validator->passes()) {
                return $password;
            }

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
        }
    }
}
