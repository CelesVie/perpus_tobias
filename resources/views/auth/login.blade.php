<x-layouts.guest title="Masuk">
    <h1 class="font-display text-3xl font-semibold">Masuk ke akun</h1>
    <p class="mt-2 text-sm text-muted">Gunakan email dan kata sandi yang terdaftar.</p>

    @if (session('status'))
        <div class="mt-5 rounded-lg border border-accent/30 bg-accent-soft px-4 py-3 text-sm text-primary">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="mt-7 space-y-5" novalidate>
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

        <label class="flex items-center gap-2 text-sm text-muted">
            <input type="checkbox" name="remember" value="1" class="size-4 rounded border-line text-accent focus:ring-accent">
            Ingat saya
        </label>

        <button type="submit" class="btn-primary w-full">Masuk</button>
    </form>

    <p class="mt-6 text-sm text-muted">
        Belum punya akun? <a href="{{ route('register') }}" class="link">Daftar sebagai anggota</a>
    </p>

    <div class="mt-8 rounded-lg border border-line bg-surface px-4 py-3 text-xs text-muted">
        <p class="font-semibold text-ink">Akun demo</p>
        <p class="mt-1">Pustakawan: admin@pustaka.test / password</p>
        <p>Anggota: bagas.prakoso@example.test / password</p>
    </div>
</x-layouts.guest>
