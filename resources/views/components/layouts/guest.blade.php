<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Masuk' }} &middot; Pustaka Nusantara</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-paper">
<div class="grid min-h-screen lg:grid-cols-2">

    <aside class="relative hidden flex-col justify-between overflow-hidden bg-primary p-10 text-white lg:flex">
        <div class="absolute inset-0 opacity-[0.14]" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 22px 22px;"></div>
        <a href="{{ route('home') }}" class="relative flex items-center gap-3">
            <span class="grid size-10 place-items-center rounded-lg bg-white/10"><x-icon name="library" class="size-5" /></span>
            <span class="font-display text-xl font-semibold">Pustaka Nusantara</span>
        </a>
        <div class="relative max-w-sm">
            <p class="eyebrow !text-accent-soft">Perpustakaan terbuka</p>
            <p class="mt-3 font-display text-3xl leading-tight">
                {{ \App\Models\Setting::get('library_tagline') }}
            </p>
            <p class="mt-4 text-sm text-white/70">
                Telusuri {{ \App\Models\Book::count() }} judul koleksi, ajukan peminjaman, dan pantau jatuh tempo dari satu tempat.
            </p>
        </div>
        <p class="relative text-xs text-white/50">{{ \App\Models\Setting::get('library_address') }}</p>
    </aside>

    <main class="flex items-center justify-center px-5 py-12">
        <div class="w-full max-w-md">
            <a href="{{ route('home') }}" class="mb-8 inline-flex items-center gap-2 text-sm text-muted hover:text-ink lg:hidden">
                <x-icon name="chevron-left" class="size-4" /> Kembali ke beranda
            </a>
            {{ $slot }}
        </div>
    </main>
</div>
</body>
</html>
