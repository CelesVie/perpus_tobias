<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Area anggota' }} &middot; Pustaka Nusantara</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-paper">

<header class="sticky top-0 z-40 border-b border-line bg-surface">
    <div class="mx-auto flex h-16 max-w-6xl items-center gap-4 px-4 sm:px-6">
        <a href="{{ route('member.dashboard') }}" class="flex items-center gap-2.5">
            <span class="grid size-9 place-items-center rounded-lg bg-primary text-white"><x-icon name="library" class="size-5" /></span>
            <span class="leading-tight">
                <span class="block font-display text-base font-semibold">Pustaka</span>
                <span class="block text-[10px] font-semibold tracking-[0.2em] text-muted uppercase">Area anggota</span>
            </span>
        </a>

        <div class="ml-auto flex items-center gap-2">
            <a href="{{ route('home') }}" class="btn-ghost btn-sm">Situs publik</a>
            <div class="relative" x-data="{ open: false }" @keydown.escape.window="open = false">
                <button type="button" @click="open = !open" aria-haspopup="menu" :aria-expanded="open"
                    class="flex items-center gap-2 rounded-lg border border-line px-2.5 py-1.5 text-sm hover:bg-paper">
                    <span class="grid size-7 place-items-center rounded-full bg-accent-soft text-xs font-bold text-primary">
                        {{ auth()->user()->initials() }}
                    </span>
                    <span class="hidden sm:inline">{{ \Illuminate\Support\Str::limit(auth()->user()->name, 16) }}</span>
                    <x-icon name="chevron-down" class="size-3.5 text-muted" />
                </button>
                <div x-show="open" x-cloak @click.outside="open = false" role="menu"
                    class="absolute right-0 mt-2 w-48 overflow-hidden rounded-xl border border-line bg-surface py-1 shadow-lg">
                    <a href="{{ route('member.profile.edit') }}" class="flex items-center gap-2 px-3.5 py-2 text-sm hover:bg-paper" role="menuitem">
                        <x-icon name="user" class="size-4" /> Profil saya
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="flex w-full items-center gap-2 px-3.5 py-2 text-left text-sm hover:bg-paper" role="menuitem">
                            <x-icon name="log-out" class="size-4" /> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<x-flash />

<div class="mx-auto grid max-w-6xl gap-8 px-4 py-8 sm:px-6 lg:grid-cols-[220px_1fr]">
    <aside class="lg:sticky lg:top-24 lg:self-start">
        <nav class="no-scrollbar flex gap-1 overflow-x-auto rounded-xl border border-line bg-surface p-2 lg:flex-col" aria-label="Navigasi anggota">
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
                   class="flex shrink-0 items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium transition
                    {{ request()->routeIs($pattern) ? 'bg-primary text-white' : 'text-muted hover:bg-paper hover:text-ink' }}">
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
