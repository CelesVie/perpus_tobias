<x-layouts.guest title="Masuk">
    <p class="font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase">Area anggota</p>
    <h1 class="mt-4 font-serif-display text-5xl font-bold leading-none tracking-tight sm:text-6xl">Masuk ke akun</h1>
    <p class="mt-5 text-base text-muted">Gunakan email dan kata sandi yang terdaftar.</p>

    @if (session('status'))
        <div class="mt-5 border border-black px-4 py-3 text-sm text-black">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="mt-10 space-y-6" novalidate>
        @csrf

        <div>
            <label class="label" for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                   class="field @error('email') field-error @enderror" placeholder="nama@contoh.com">
            @error('email') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="label" for="password">Kata sandi</label>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                   class="field @error('password') field-error @enderror" placeholder="••••••••">
            @error('password') <p class="error">{{ $message }}</p> @enderror
        </div>

        <label class="flex items-center gap-2 font-sans text-xs text-muted">
            <input type="checkbox" name="remember" value="1" class="size-4 rounded-none border-black text-black focus:ring-black">
            Ingat saya
        </label>

        <button type="submit" class="btn-primary w-full">Masuk</button>
    </form>

    <p class="mt-8 border-t border-black pt-5 text-sm text-muted">
        Belum punya akun? <a href="{{ route('register') }}" class="link">Daftar sebagai anggota</a>
    </p>

    <div class="mt-8 border-t border-line pt-4 font-sans text-[10px] leading-relaxed text-muted">
        <p class="font-semibold tracking-[0.15em] uppercase">Akun demo</p>
        <p class="mt-1">Pustakawan: admin@pustaka.test / password</p>
        <p>Anggota: bagas.prakoso@example.test / password</p>
    </div>
</x-layouts.guest>
