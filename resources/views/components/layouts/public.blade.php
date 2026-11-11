<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Pustaka Nusantara' }}</title>
    <meta name="description" content="{{ $description ?? 'Katalog dan layanan Perpustakaan Pustaka Nusantara.' }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">

<header class="sticky top-0 z-40 border-b border-line/80 bg-paper/90 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-6xl items-center gap-6 px-4 sm:px-6">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            <span class="grid size-9 place-items-center rounded-lg bg-primary text-white">
                <x-icon name="library" class="size-5" />
            </span>
            <span class="leading-tight">
                <span class="block font-display text-lg font-semibold">Pustaka</span>
                <span class="block text-[10px] font-semibold tracking-[0.2em] text-muted uppercase">Nusantara</span>
            </span>
        </a>

        <nav class="hidden items-center gap-1 text-sm md:flex" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 font-medium {{ request()->routeIs('home') ? 'bg-primary-ghost text-ink' : 'text-muted hover:text-ink' }}">Beranda</a>
            <a href="{{ route('books.index') }}" class="rounded-lg px-3 py-2 font-medium {{ request()->routeIs('books.*') ? 'bg-primary-ghost text-ink' : 'text-muted hover:text-ink' }}">Katalog</a>
            <a href="{{ route('categories.index') }}" class="rounded-lg px-3 py-2 font-medium {{ request()->routeIs('categories.*') ? 'bg-primary-ghost text-ink' : 'text-muted hover:text-ink' }}">Kategori</a>
            <a href="{{ route('about') }}" class="rounded-lg px-3 py-2 font-medium {{ request()->routeIs('about') ? 'bg-primary-ghost text-ink' : 'text-muted hover:text-ink' }}">Tentang</a>
        </nav>

        <div class="ml-auto flex items-center gap-2">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-outline btn-sm">
                    <x-icon name="layout-dashboard" class="size-4" />
                    <span class="hidden sm:inline">Dasbor</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn-ghost btn-sm" type="submit">
                        <x-icon name="log-out" class="size-4" />
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-ghost btn-sm">Masuk</a>
                <a href="{{ route('register') }}" class="btn-primary btn-sm">Daftar Anggota</a>
            @endauth
        </div>
    </div>

    <div class="border-t border-line md:hidden">
        <nav class="no-scrollbar mx-auto flex max-w-6xl gap-1 overflow-x-auto px-4 py-2 text-sm" aria-label="Navigasi seluler">
            <a href="{{ route('home') }}" class="shrink-0 rounded-lg px-3 py-1.5 font-medium text-muted">Beranda</a>
            <a href="{{ route('books.index') }}" class="shrink-0 rounded-lg px-3 py-1.5 font-medium text-muted">Katalog</a>
            <a href="{{ route('categories.index') }}" class="shrink-0 rounded-lg px-3 py-1.5 font-medium text-muted">Kategori</a>
            <a href="{{ route('about') }}" class="shrink-0 rounded-lg px-3 py-1.5 font-medium text-muted">Tentang</a>
        </nav>
    </div>
</header>

<x-flash />

<main class="flex-1">
    {{ $slot }}
</main>

<footer class="mt-16 border-t border-line bg-surface">
    <div class="mx-auto grid max-w-6xl gap-8 px-4 py-12 sm:px-6 md:grid-cols-4">
        <div class="md:col-span-2">
            <p class="font-display text-xl font-semibold">Pustaka Nusantara</p>
            <p class="mt-2 max-w-sm text-sm text-muted">{{ \App\Models\Setting::get('library_tagline') }}</p>
            <p class="mt-4 text-sm text-muted">{{ \App\Models\Setting::get('library_address') }}</p>
        </div>
        <div>
            <p class="text-xs font-bold tracking-widest text-ink uppercase">Jelajahi</p>
            <ul class="mt-3 space-y-2 text-sm text-muted">
                <li><a href="{{ route('books.index') }}" class="hover:text-ink">Katalog buku</a></li>
                <li><a href="{{ route('categories.index') }}" class="hover:text-ink">Kategori</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-ink">Tentang perpustakaan</a></li>
            </ul>
        </div>
        <div>
            <p class="text-xs font-bold tracking-widest text-ink uppercase">Kontak</p>
            <ul class="mt-3 space-y-2 text-sm text-muted">
                <li class="flex items-center gap-2"><x-icon name="phone" class="size-4" />{{ \App\Models\Setting::get('library_phone') }}</li>
                <li class="flex items-center gap-2"><x-icon name="mail" class="size-4" />{{ \App\Models\Setting::get('library_email') }}</li>
            </ul>
        </div>
    </div>
    <div class="border-t border-line px-4 py-4 text-center text-xs text-muted">
        &copy; {{ now()->year }} Pustaka Nusantara. Dibangun untuk kebutuhan UKK.
    </div>
</footer>

</body>
</html>
