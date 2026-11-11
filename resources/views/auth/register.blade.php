<x-layouts.guest title="Daftar anggota">
    <p class="font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase">Keanggotaan</p>
    <h1 class="mt-4 font-serif-display text-5xl font-bold leading-none tracking-tight sm:text-6xl">Daftar sebagai anggota</h1>
    <p class="mt-5 text-base text-muted">Gratis. Anda bisa langsung mengajukan peminjaman setelah akun dibuat.</p>

    <form method="POST" action="{{ route('register.store') }}" class="mt-10 space-y-6">
        @csrf

        <div>
            <label class="label" for="name">Nama lengkap</label>
            <input id="name" name="name" value="{{ old('name') }}" required autocomplete="name"
                   class="field @error('name') field-error @enderror" placeholder="Nama sesuai kartu identitas">
            @error('name') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="label" for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"
                   class="field @error('email') field-error @enderror" placeholder="nama@contoh.com">
            @error('email') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label class="label" for="phone">Nomor telepon</label>
                <input id="phone" name="phone" value="{{ old('phone') }}" inputmode="tel"
                       class="field @error('phone') field-error @enderror" placeholder="08xxxxxxxxxx">
                @error('phone') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="label" for="address">Alamat</label>
                <input id="address" name="address" value="{{ old('address') }}"
                       class="field @error('address') field-error @enderror" placeholder="Kecamatan, kota">
                @error('address') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="label" for="password">Kata sandi</label>
            <input id="password" name="password" type="password" required autocomplete="new-password"
                   class="field @error('password') field-error @enderror" placeholder="Minimal 8 karakter">
            @error('password') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="label" for="password_confirmation">Ulangi kata sandi</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                   class="field" placeholder="Ketik ulang kata sandi">
        </div>

        <button type="submit" class="btn-primary w-full">Buat akun</button>
    </form>

    <p class="mt-8 border-t border-black pt-5 text-sm text-muted">
        Sudah punya akun? <a href="{{ route('login') }}" class="link">Masuk</a>
    </p>
</x-layouts.guest>
