<x-layouts.member title="Profil saya">
    <h1 class="font-display text-5xl font-bold leading-none tracking-tight sm:text-7xl">Profil saya</h1>
    <p class="eyebrow mt-4">Perbarui data kontak dan kata sandi akun Anda.</p>

    <div class="mt-6 grid gap-5 lg:grid-cols-[1fr_280px]">
        <form method="POST" action="{{ route('member.profile.update') }}" class="panel space-y-5">
            @csrf @method('PATCH')

            <div>
                <label class="label" for="name">Nama lengkap</label>
                <input id="name" name="name" value="{{ old('name', $user->name) }}" required class="field @error('name') field-error @enderror">
                @error('name') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="label" for="phone">Telepon</label>
                    <input id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="field @error('phone') field-error @enderror">
                    @error('phone') <p class="error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="label" for="address">Alamat</label>
                    <input id="address" name="address" value="{{ old('address', $user->address) }}" class="field @error('address') field-error @enderror">
                    @error('address') <p class="error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="border-t border-line pt-5">
                <p class="text-sm font-semibold">Ganti kata sandi</p>
                <p class="help mb-4">Kosongkan bila tidak ingin mengganti.</p>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="label" for="password">Kata sandi baru</label>
                        <input id="password" name="password" type="password" class="field @error('password') field-error @enderror" autocomplete="new-password">
                        @error('password') <p class="error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="label" for="password_confirmation">Ulangi kata sandi</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="field" autocomplete="new-password">
                    </div>
                </div>
            </div>

            <button class="btn-primary" type="submit">Simpan perubahan</button>
        </form>

        <aside class="panel h-fit">
            <div class="flex items-center gap-3">
                <span class="grid size-12 place-items-center rounded-none border border-black bg-white font-display text-lg font-semibold text-black">
                    {{ $user->initials() }}
                </span>
                <div class="min-w-0">
                    <p class="truncate font-semibold">{{ $user->name }}</p>
                    <p class="truncate text-xs text-muted">{{ $user->email }}</p>
                </div>
            </div>
            <dl class="mt-4 space-y-2 border-t border-line pt-4 text-sm">
                <div class="flex justify-between"><dt class="text-muted">Nomor anggota</dt><dd class="font-mono text-xs">#{{ str_pad((string) $user->id, 4, '0', STR_PAD_LEFT) }}</dd></div>
                <div class="flex justify-between"><dt class="text-muted">Bergabung</dt><dd>{{ $user->joined_at?->translatedFormat('d M Y') ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-muted">Pinjaman aktif</dt><dd>{{ $user->activeLoanCount() }}</dd></div>
                <div class="flex justify-between"><dt class="text-muted">Denda</dt><dd>Rp{{ number_format($user->unpaidFineTotal(), 0, ',', '.') }}</dd></div>
                <div class="flex justify-between"><dt class="text-muted">Status</dt>
                    <dd><x-status-badge :status="$user->is_active ? 'paid' : 'unpaid'" /></dd>
                </div>
            </dl>
        </aside>
    </div>
</x-layouts.member>
