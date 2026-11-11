@props(['status'])

@php
    $map = [
        'requested' => ['bg-amber-50 text-amber-700 border-amber-200', 'Menunggu'],
        'approved' => ['bg-accent-soft text-primary border-accent/30', 'Dipinjam'],
        'returned' => ['bg-primary-ghost text-primary border-line', 'Dikembalikan'],
        'rejected' => ['bg-red-50 text-red-700 border-red-200', 'Ditolak'],
        'cancelled' => ['bg-neutral-100 text-muted border-line', 'Dibatalkan'],
        'unpaid' => ['bg-red-50 text-red-700 border-red-200', 'Belum dibayar'],
        'paid' => ['bg-accent-soft text-accent border-accent/30', 'Lunas'],
    ];

    [$classes, $label] = $map[$status] ?? ['bg-primary-ghost text-muted border-line', ucfirst($status)];
@endphp

<span {{ $attributes->merge(['class' => "badge border {$classes}"]) }}>{{ $label }}</span>
