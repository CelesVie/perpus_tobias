<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Area pustakawan' }} &middot; Pustaka Nusantara</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-black" x-data="{ sidebar: false }">

<div class="flex min-h-screen">
    <aside class="fixed inset-y-0 left-0 z-40 w-64 overflow-y-auto border-r border-black bg-white text-black transition-transform lg:static lg:!translate-x-0"
           :class="sidebar ? 'translate-x-0' : '-translate-x-full'">
        <div class="flex h-16 items-center gap-2.5 border-b border-black px-5">
            <div class="leading-tight">
                <p class="font-serif-display text-2xl font-bold leading-none tracking-tight">Pustaka</p>
                <p class="mt-1 font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase">Ruang pustakawan</p>
            </div>
            <button class="ml-auto lg:hidden" @click="sidebar = false" aria-label="Tutup menu"><x-icon name="x" class="size-5" /></button>
        </div>

        <nav class="space-y-6 p-4 text-sm" aria-label="Navigasi admin">
            @php
                $groups = [
                    'Ringkasan' => [
                        ['admin.dashboard', 'layout-dashboard', 'Dasbor', 'admin.dashboard'],
                    ],
                    'Koleksi' => [
                        ['admin.books.index', 'book-open', 'Buku', 'admin.books.*'],
                        ['admin.categories.index', 'tags', 'Kategori', 'admin.categories.*'],
                        ['admin.authors.index', 'pencil', 'Penulis', 'admin.authors.*'],
                        ['admin.publishers.index', 'library', 'Penerbit', 'admin.publishers.*'],
                    ],
                    'Sirkulasi' => [
                        ['admin.borrowings.index', 'clipboard-list', 'Peminjaman', 'admin.borrowings.*'],
                        ['admin.returns.index', 'undo-2', 'Pengembalian', 'admin.returns.*'],
                        ['admin.fines.index', 'receipt', 'Denda', 'admin.fines.*'],
                    ],
                    'Lainnya' => [
                        ['admin.members.index', 'users', 'Anggota', 'admin.members.*'],
                        ['admin.reports.index', 'bar-chart-3', 'Laporan', 'admin.reports.*'],
                        ['admin.settings.edit', 'settings', 'Pengaturan', 'admin.settings.*'],
                    ],
                ];
            @endphp

            @foreach ($groups as $group => $items)
                <div>
                    <p class="border-t border-black px-3 pt-4 font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase">{{ $group }}</p>
                    <div class="mt-2 space-y-0.5">
                        @foreach ($items as [$route, $icon, $label, $pattern])
                            <a href="{{ route($route) }}"
                               class="flex items-center gap-2.5 border-l-2 px-3 py-2 font-sans text-xs tracking-wide transition
                                {{ request()->routeIs($pattern) ? 'border-black bg-primary-ghost font-semibold text-black' : 'border-transparent text-muted hover:border-black hover:text-black' }}">
                                <x-icon :name="$icon" class="size-4" />{{ $label }}
                                @if ($route === 'admin.borrowings.index' && ($pendingCount ?? 0) > 0)
                                    <span class="ml-auto border border-black px-1.5 py-0.5 font-sans text-[10px] font-bold">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </nav>

        <div class="border-t border-black p-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-sans text-[10px] tracking-[0.15em] text-muted uppercase hover:text-black">
                <x-icon name="arrow-up-right" class="size-4" /> Lihat situs publik
            </a>
        </div>
    </aside>

    <div x-show="sidebar" x-cloak @click="sidebar = false" class="fixed inset-0 z-30 bg-black/40 lg:hidden"></div>

    <div class="flex min-w-0 flex-1 flex-col">
        <header class="sticky top-0 z-20 flex h-16 items-center gap-3 border-b border-black bg-white px-4 sm:px-6">
            <button class="btn-ghost btn-sm lg:hidden" @click="sidebar = true" aria-label="Buka menu">
                <x-icon name="menu" class="size-5" />
            </button>
            <p class="font-serif-display text-2xl font-bold leading-none tracking-tight">{{ $heading ?? 'Ruang pustakawan' }}</p>

            <div class="ml-auto flex items-center gap-2">
                <div class="relative" x-data="{ open: false }" @keydown.escape.window="open = false">
                    <button type="button" @click="open = !open" :aria-expanded="open" aria-haspopup="menu"
                        class="flex items-center gap-2 border border-black px-2.5 py-1.5 text-xs hover:bg-primary-ghost">
                        <span class="grid size-7 place-items-center border border-black font-sans text-[10px] font-bold">
                            {{ auth()->user()->initials() }}
                        </span>
                        <span class="hidden sm:inline">{{ \Illuminate\Support\Str::limit(auth()->user()->name, 14) }}</span>
                        <x-icon name="chevron-down" class="size-3.5 text-muted" />
                    </button>
                    <div x-show="open" x-cloak @click.outside="open = false" role="menu"
                        class="absolute right-0 mt-2 w-44 overflow-hidden border border-black bg-white py-1">
                        <p class="px-3.5 py-2 font-sans text-[10px] tracking-[0.15em] text-muted uppercase">{{ auth()->user()->role->label() }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="flex w-full items-center gap-2 px-3.5 py-2 text-left text-sm hover:bg-primary-ghost" role="menuitem">
                                <x-icon name="log-out" class="size-4" /> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <x-flash />

        <main class="mx-auto w-full max-w-screen-2xl flex-1 px-5 py-10 sm:px-8 lg:px-12">
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
