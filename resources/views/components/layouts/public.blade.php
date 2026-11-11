<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Pustaka Nusantara' }}</title>
    <meta name="description" content="{{ $description ?? 'Katalog dan layanan Perpustakaan Pustaka Nusantara.' }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">

<header class="border-b border-black bg-white">
    <div class="mx-auto flex min-h-20 max-w-screen-2xl flex-wrap items-center gap-x-10 gap-y-4 px-5 py-5 sm:px-8 lg:px-12">
        <a href="{{ route('home') }}" class="font-serif-display text-4xl font-bold leading-none tracking-tight sm:text-5xl" aria-label="Pustaka Nusantara — Beranda">
            Pustaka<span class="ml-2 align-middle font-sans text-[10px] font-semibold tracking-[0.15em] uppercase">Nusantara</span>
        </a>

        <nav class="order-3 flex w-full items-center gap-x-7 md:order-none md:w-auto" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" @class(['font-sans text-[10px] font-semibold tracking-[0.15em] uppercase underline underline-offset-4' => request()->routeIs('home'), 'font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase hover:text-black' => ! request()->routeIs('home')])>Beranda</a>
            <a href="{{ route('books.index') }}" @class(['font-sans text-[10px] font-semibold tracking-[0.15em] uppercase underline underline-offset-4' => request()->routeIs('books.*'), 'font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase hover:text-black' => ! request()->routeIs('books.*')])>Katalog</a>
            <a href="{{ route('categories.index') }}" @class(['font-sans text-[10px] font-semibold tracking-[0.15em] uppercase underline underline-offset-4' => request()->routeIs('categories.*'), 'font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase hover:text-black' => ! request()->routeIs('categories.*')])>Kategori</a>
            <a href="{{ route('about') }}" @class(['font-sans text-[10px] font-semibold tracking-[0.15em] uppercase underline underline-offset-4' => request()->routeIs('about'), 'font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase hover:text-black' => ! request()->routeIs('about')])>Tentang</a>
        </nav>

        <div class="ml-auto flex items-center gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="font-sans text-[10px] font-semibold tracking-[0.15em] uppercase underline underline-offset-4">Dasbor</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase hover:text-accent" type="submit">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="font-sans text-[10px] font-semibold tracking-[0.15em] uppercase">Masuk</a>
                <a href="{{ route('register') }}" class="border border-black bg-black px-3 py-2 font-sans text-[10px] font-semibold tracking-[0.15em] text-white uppercase hover:bg-white hover:text-black">Daftar Anggota</a>
            @endauth
        </div>
    </div>
</header>

<x-flash />

<main class="flex-1">
    {{ $slot }}
</main>

<footer class="mt-20 border-t border-black bg-white">
    <div class="mx-auto grid max-w-screen-2xl gap-10 px-5 py-14 sm:px-8 md:grid-cols-4 lg:px-12">
        <div class="md:col-span-2">
            <p class="font-serif-display text-3xl font-bold leading-none tracking-tight">Pustaka Nusantara</p>
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
    <div class="border-t border-black px-5 py-4 text-center font-sans text-[10px] tracking-[0.15em] text-muted uppercase">
        &copy; {{ now()->year }} Pustaka Nusantara. Dibangun untuk kebutuhan UKK.
    </div>
</footer>

</body>
</html>
