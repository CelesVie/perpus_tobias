<x-layouts.admin :title="'Ubah '.$member->name" heading="Ubah anggota">
    <a href="{{ route('admin.members.show', $member) }}" class="inline-flex items-center gap-1 text-sm text-muted hover:text-ink">
        <x-icon name="chevron-left" class="size-4" /> Detail anggota
    </a>

    <div class="mt-4 max-w-3xl">
        <p class="font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase">Anggota / Perbarui akun</p>
        <h1 class="mt-3 font-serif-display text-5xl font-bold leading-none tracking-tight sm:text-7xl">Ubah data anggota</h1>
        <p class="mt-5 text-base text-muted">
            Perbarui identitas dan kontak anggota. Kata sandi hanya berubah bila kolomnya diisi.
        </p>

        <form method="POST" action="{{ route('admin.members.update', $member) }}"
              class="mt-8 space-y-7 border-y border-black py-6">
            @csrf
            @method('PUT')

            <div>
                <label class="label" for="name">Nama lengkap</label>
                <input id="name" name="name" value="{{ old('name', $member->name) }}" required
                       class="field @error('name') field-error @enderror">
                @error('name') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="label" for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $member->email) }}" required
                           class="field @error('email') field-error @enderror">
                    @error('email') <p class="error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="label" for="phone">Nomor telepon</label>
                    <input id="phone" name="phone" value="{{ old('phone', $member->phone) }}"
                           class="field @error('phone') field-error @enderror">
                    @error('phone') <p class="error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="label" for="address">Alamat</label>
                <textarea id="address" name="address" rows="2"
                          class="field @error('address') field-error @enderror">{{ old('address', $member->address) }}</textarea>
                @error('address') <p class="error">{{ $message }}</p> @enderror
            </div>

            <fieldset class="space-y-5 border-t border-black pt-5">
                <legend class="label">Ganti kata sandi</legend>
                <p class="help -mt-2">Kosongkan jika tidak ingin mengubah kata sandi.</p>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="label" for="password">Kata sandi baru</label>
                        <input id="password" name="password" type="password" autocomplete="new-password"
                               class="field @error('password') field-error @enderror">
                        <p class="help mt-1.5">Minimal 8 karakter.</p>
                        @error('password') <p class="error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="label" for="password_confirmation">Konfirmasi kata sandi</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                               autocomplete="new-password" class="field">
                    </div>
                </div>
            </fieldset>

            <div class="flex gap-2 border-t border-line pt-5">
                <button class="btn-primary" type="submit">Simpan perubahan</button>
                <a href="{{ route('admin.members.show', $member) }}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</x-layouts.admin>