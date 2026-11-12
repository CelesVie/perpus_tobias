<x-layouts.public title="Tentang perpustakaan" description="Profil singkat, jam layanan, dan aturan peminjaman Pustaka Nusantara.">
    <x-page-header name="Tentang" title="Tentang Pustaka Nusantara"
        description="Perpustakaan umum yang dikelola untuk mendukung literasi warga dan pelajar di kota ini." />

    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6">
        <div class="grid gap-8 lg:grid-cols-[1.3fr_0.7fr]">
            <div class="space-y-8">
                <section class="panel">
                    <h2 class="font-display text-3xl font-bold leading-none tracking-tight sm:text-4xl">Tujuan kami</h2>
                    <p class="mt-3 leading-relaxed text-ink/90">
                        Pustaka Nusantara mengelola {{ number_format($titles, 0, ',', '.') }} judul untuk {{ number_format($members, 0, ',', '.') }} anggota terdaftar.
                        Kami percaya akses bacaan yang mudah adalah awal dari warga yang kritis. Katalog terbuka untuk
                        siapa pun, dan keanggotaan diberikan gratis.
                    </p>
                    <p class="mt-3 leading-relaxed text-ink/90">
                        Aplikasi ini dipakai staf untuk mengelola koleksi, menyetujui peminjaman, memproses pengembalian, serta
                        mencatat denda keterlambatan secara transparan bagi anggota.
                    </p>
                </section>

                <section class="panel">
                    <h2 class="font-display text-3xl font-bold leading-none tracking-tight sm:text-4xl">Aturan peminjaman</h2>
                    <ul class="mt-4 space-y-3 text-sm">
                        @foreach ([
                            'Maksimal '.\App\Models\Setting::get('max_active_loans').' peminjaman aktif per anggota.',
                            'Durasi pinjam '.\App\Models\Setting::get('loan_duration_days').' hari sejak permohonan disetujui.',
                            'Denda Rp'.\App\Models\Setting::get('fine_per_day').' per hari keterlambatan.',
                            'Permohonan baru diproses pustakawan pada jam layanan.',
                            'Satu judul hanya boleh diajukan satu kali selama masih aktif.',
                        ] as $rule)
                            <li class="flex gap-3">
                                <x-icon name="check" class="mt-0.5 size-4 shrink-0 text-accent" />
                                <span>{{ $rule }}</span>
                            </li>
                        @endforeach
                    </ul>
                </section>
            </div>

            <aside class="space-y-5">
                <div class="panel">
                    <h2 class="text-xs font-bold tracking-widest uppercase">Kunjungi</h2>
                    <ul class="mt-3 space-y-3 text-sm text-muted">
                        <li class="flex gap-2"><x-icon name="map-pin" class="size-4 shrink-0" />{{ \App\Models\Setting::get('library_address') }}</li>
                        <li class="flex gap-2"><x-icon name="phone" class="size-4 shrink-0" />{{ \App\Models\Setting::get('library_phone') }}</li>
                        <li class="flex gap-2"><x-icon name="mail" class="size-4 shrink-0" />{{ \App\Models\Setting::get('library_email') }}</li>
                    </ul>
                </div>
                <div class="panel">
                    <h2 class="text-xs font-bold tracking-widest uppercase">Jam layanan</h2>
                    <dl class="mt-3 space-y-2 text-sm">
                        <div class="flex justify-between"><dt class="text-muted">Senin–Jumat</dt><dd class="font-medium">08.00–16.00</dd></div>
                        <div class="flex justify-between"><dt class="text-muted">Sabtu</dt><dd class="font-medium">09.00–13.00</dd></div>
                        <div class="flex justify-between"><dt class="text-muted">Minggu</dt><dd class="text-muted">Tutup</dd></div>
                    </dl>
                </div>
            </aside>
        </div>
    </div>
</x-layouts.public>
