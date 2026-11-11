<x-layouts.admin title="Pengaturan" heading="Pengaturan">
    <div class="max-w-2xl">
        <h1 class="font-display text-2xl font-semibold">Pengaturan aplikasi</h1>
        <p class="mt-1 text-sm text-muted">Aturan peminjaman dan identitas perpustakaan yang dipakai di seluruh halaman.</p>

        <form method="POST" action="{{ route('admin.settings.update') }}" class="mt-6 space-y-5 panel">
            @csrf @method('PATCH')

            <div>
                <label class="label" for="library_name">Nama perpustakaan</label>
                <input id="library_name" name="library_name" value="{{ old('library_name', $values['library_name']) }}"
                       required class="field @error('library_name') field-error @enderror">
                @error('library_name') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label" for="library_tagline">Tagline</label>
                <input id="library_tagline" name="library_tagline" value="{{ old('library_tagline', $values['library_tagline']) }}"
                       class="field @error('library_tagline') field-error @enderror">
                @error('library_tagline') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="label" for="library_phone">Telepon</label>
                    <input id="library_phone" name="library_phone" value="{{ old('library_phone', $values['library_phone']) }}" class="field">
                </div>
                <div>
                    <label class="label" for="library_email">Email</label>
                    <input id="library_email" name="library_email" type="email" value="{{ old('library_email', $values['library_email']) }}"
                           class="field @error('library_email') field-error @enderror">
                    @error('library_email') <p class="error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="label" for="library_address">Alamat</label>
                <input id="library_address" name="library_address" value="{{ old('library_address', $values['library_address']) }}" class="field">
            </div>

            <div class="border-t border-line pt-5">
                <h2 class="text-sm font-bold tracking-wide uppercase">Aturan sirkulasi</h2>
                <div class="mt-4 grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="label" for="loan_duration_days">Durasi pinjam (hari)</label>
                        <input id="loan_duration_days" name="loan_duration_days" type="number" min="1" max="90"
                               value="{{ old('loan_duration_days', $values['loan_duration_days']) }}"
                               class="field @error('loan_duration_days') field-error @enderror">
                        @error('loan_duration_days') <p class="error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="label" for="max_active_loans">Maks. pinjaman aktif</label>
                        <input id="max_active_loans" name="max_active_loans" type="number" min="1" max="10"
                               value="{{ old('max_active_loans', $values['max_active_loans']) }}"
                               class="field @error('max_active_loans') field-error @enderror">
                        @error('max_active_loans') <p class="error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="label" for="fine_per_day">Denda per hari (Rp)</label>
                        <input id="fine_per_day" name="fine_per_day" type="number" min="0" max="100000"
                               value="{{ old('fine_per_day', $values['fine_per_day']) }}"
                               class="field @error('fine_per_day') field-error @enderror">
                        @error('fine_per_day') <p class="error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="label" for="max_fine_days">Batas hari denda</label>
                        <input id="max_fine_days" name="max_fine_days" type="number" min="1" max="365"
                               value="{{ old('max_fine_days', $values['max_fine_days']) }}"
                               class="field @error('max_fine_days') field-error @enderror">
                        @error('max_fine_days') <p class="error">{{ $message }}</p> @enderror
                    </div>
                </div>
                <p class="help mt-2">Perubahan berlaku untuk transaksi berikutnya, bukan transaksi yang sudah berjalan.</p>
            </div>

            <button class="btn-primary" type="submit">Simpan pengaturan</button>
        </form>
    </div>
</x-layouts.admin>
