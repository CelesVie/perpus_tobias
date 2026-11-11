<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Masuk' }} &middot; Pustaka Nusantara</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-black">
<div class="min-h-screen">

    <aside class="hidden items-center justify-between border-b border-black px-5 py-6 sm:px-8 lg:flex lg:px-12">
        <a href="{{ route('home') }}" class="font-serif-display text-3xl font-bold leading-none tracking-tight">
            Pustaka Nusantara
        </a>
        <p class="font-sans text-[10px] tracking-[0.15em] text-muted uppercase">Akses anggota · Pustaka Nusantara</p>
    </aside>

    <main class="mx-auto flex min-h-[75vh] w-full max-w-6xl items-center justify-center px-5 py-16 sm:px-8 lg:px-12">
        <div class="w-full max-w-xl border-y border-black py-10 sm:py-14">
            <a href="{{ route('home') }}" class="mb-10 inline-flex items-center gap-2 font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase hover:text-black lg:hidden">
                <x-icon name="chevron-left" class="size-4" /> Beranda
            </a>
            {{ $slot }}
        </div>
    </main>
</div>
</body>
</html>
