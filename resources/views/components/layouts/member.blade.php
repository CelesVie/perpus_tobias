<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Area anggota' }} &middot; Pustaka Nusantara</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-black">

<header class="border-b border-black bg-white">
    <div class="mx-auto flex min-h-20 max-w-screen-2xl items-center gap-4 px-5 py-4 sm:px-8 lg:px-12">
        <a href="{{ route('member.dashboard') }}" class="flex items-center gap-2.5">
            <span class="leading-tight">
                <span class="block font-serif-display text-3xl font-bold leading-none tracking-tight">Pustaka</span>
                <span class="mt-1 block font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase">Area anggota</span>
            </span>
        </a>

        <div class="ml-auto flex items-center gap-2">
            <a href="{{ route('home') }}" class="btn-ghost btn-sm">Situs publik</a>
            <div class="relative" x-data="{ open: false }" @keydown.escape.window="open = false">
                <button type="button" @click="open = !open" aria-haspopup="menu" :aria-expanded="open"
                    class="flex items-center gap-2 border border-black px-2.5 py-1.5 text-xs hover:bg-primary-ghost">
                    <span class="grid size-7 place-items-center border border-black font-sans text-[10px] font-bold">
                        {{ auth()->user()->initials() }}
                    </span>
                    <span class="hidden sm:inline">{{ \Illuminate\Support\Str::limit(auth()->user()->name, 16) }}</span>
                    <x-icon name="chevron-down" class="size-3.5 text-muted" />
                </button>
                <div x-show="open" x-cloak @click.outside="open = false" role="menu"
                    class="absolute right-0 mt-2 w-48 overflow-hidden border border-black bg-white py-1">
                    <a href="{{ route('member.profile.edit') }}" class="flex items-center gap-2 px-3.5 py-2 text-sm hover:bg-primary-ghost" role="menuitem">
                        <x-icon name="user" class="size-4" /> Profil saya
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="flex w-full items-center gap-2 px-3.5 py-2 text-left text-sm hover:bg-primary-ghost" role="menuitem">
                            <x-icon name="log-out" class="size-4" /> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<x-flash />

<div class="mx-auto grid w-full max-w-screen-2xl gap-8 px-5 py-10 sm:px-8 lg:grid-cols-[240px_1fr] lg:px-12">
    <aside class="lg:sticky lg:top-24 lg:self-start">
        <nav class="no-scrollbar flex gap-1 overflow-x-auto border-y border-black py-2 lg:sticky lg:top-8 lg:flex-col" aria-label="Navigasi anggota">
            @php
                $links = [
                    ['member.dashboard', 'layout-dashboard', 'Dasbor', 'member.dashboard'],
                    ['member.books', 'book-open', 'Katalog', 'member.books*'],
                    ['member.borrowings.index', 'clipboard-list', 'Peminjaman', 'member.borrowings.*'],
                    ['member.history', 'rotate-ccw', 'Riwayat & denda', 'member.history'],
                    ['member.profile.edit', 'user', 'Profil', 'member.profile.*'],
                ];
            @endphp
            @foreach ($links as [$route, $icon, $label, $pattern])
                <a href="{{ route($route) }}"
                   class="flex shrink-0 items-center gap-2.5 border-l-2 px-3 py-2 font-sans text-xs tracking-wide transition
                    {{ request()->routeIs($pattern) ? 'border-black bg-primary-ghost font-semibold text-black' : 'border-transparent text-muted hover:border-black hover:text-black' }}">
                    <x-icon :name="$icon" class="size-4" />{{ $label }}
                </a>
            @endforeach
        </nav>
    </aside>

    <main class="min-w-0">
        {{ $slot }}
    </main>
</div>
</body>
</html>
