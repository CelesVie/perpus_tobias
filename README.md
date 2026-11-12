# 📚 PUSTAKA — Sistem Informasi Perpustakaan Web

> Web manajemen perpustakaan modern dengan arsitektur backend yang rapi, alur sirkulasi buku lengkap, dan visual bergaya **Brutalist / Editorial** yang anti-mainstream.

Dibuat untuk kebutuhan tugas akhir / UKK RPL dan portofolio magang, web ini mengutamakan kerapian arsitektur kode (*clean code*), pemisahan logika bisnis yang jelas (*Service Layer*), serta pengalaman pengguna (UX) yang cepat dan informatif.

---

## 🛠️ Tech Stack & Alasan Pemilihan

| Teknologi | Peran | Alasan Pemilihan |
| :--- | :--- | :--- |
| **Laravel 12 (PHP 8.4)** | Backend Framework | Standar industri untuk web modern; routing ekspresif, ekosistem solid, dan Eloquent ORM yang memudahkan query relasional kompleks. |
| **MySQL** | Relational Database | Manajemen data terstruktur dengan integritas foreign key untuk buku, relasi penulis/penerbit, sirkulasi peminjaman, dan denda. |
| **Tailwind CSS v4** | Styling Engine | Engine CSS utility-first generasi terbaru yang super cepat, memungkinkan implementasi desain Brutalist/Editorial murni tanpa library CSS tambahan. |
| **Alpine.js** | Micro JS Framework | Interaktivitas komponen UI (modal konfirmasi, dropdown menu, tabs) tetap responsif dan interaktif tanpa overhead bundle JavaScript yang berat. |
| **Vite** | Frontend Asset Bundler | Hot Module Replacement (HMR) instan dan kompilasi stylesheet ultra-cepat. |

---

## 🚀 Fitur Andalan

- 🔄 **Sirkulasi Peminjaman End-to-End**  
  Member dapat mengajukan peminjaman secara mandiri lewat katalog. Admin memvalidasi (setujui / tolak dengan alasan), mencatat tanggal kembali, dan stok buku otomatis tersinkronisasi.
- 💰 **Kalkulasi Denda Otomatis**  
  Sistem menghitung hari keterlambatan secara otomatis terhadap tanggal jatuh tempo (*due date*) dan mengalikan dengan tarif denda harian yang fleksibel diatur dari menu pengaturan.
- 👥 **Role-Based Access Control (RBAC)**  
  Pemisahan akses tegas antara **Pustakawan (Admin)** dan **Anggota (Member)** melalui middleware:
  - **Admin**: Dashboard statistik, manajemen buku & kategori, approval peminjaman, pencatatan pengembalian, status denda, dan ekspor laporan.
  - **Member**: Akses katalog publik, detail buku, booking peminjaman, pemantauan status pinjam, serta riwayat denda pribadi.
- 📰 **Desain UI/UX Brutalist & Editorial**  
  Berbeda dari dashboard template Bootstrap konvensional, web ini mengusung estetika editorial surat kabar & gaya brutalisme: border tegas (`border-2 border-black`), kontras tinggi, grid presisi, dan tipografi monospaced/serif yang unik.
- 📦 **Master Data & Relasi Lengkap**  
  Mendukung katalog buku komprehensif: multi-penulis (*many-to-many*), penerbit, kategori, tahun terbit, halaman, status ketersediaan, serta pencarian & filter cepat.
- 📊 **Statistik & Audit Log Rapi**  
  Dashboard admin menyajikan metrik buku aktif, peminjaman pending, buku terlambat, serta total denda tertunggak secara real-time.

---

## 💻 Cara Install & Menjalankan di Lokal

Ikuti langkah-langkah *step-by-step* di terminal:

### 1. Clone Repository & Masuk ke Folder
```bash
git clone <url-repository-kamu>
cd perpustakaan_tobias
```

### 2. Install Dependensi PHP
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin file konfigurasi contoh:
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan koneksi database MySQL kamu:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pustaka_db
DB_USERNAME=root
DB_PASSWORD=
```
*(Pastikan database `pustaka_db` sudah dibuat di MySQL/phpMyAdmin)*

### 4. Generate App Key
```bash
php artisan key:generate
```

### 5. Migrasi & Seeding Data Dummy
Jalankan migrasi tabel beserta seeder data awal (buku, penulis, penerbit, akun admin, member, dan riwayat contoh):
```bash
php artisan migrate --seed
```

### 6. Install Dependensi Frontend & Build Vite
> ⚠️ **Penting:** Aplikasi ini menggunakan Tailwind CSS v4. Kamu **wajib** melakukan build aset frontend agar seluruh styling editorial dan layout brutalist tampil sempurna!

```bash
# Install paket JS
npm install

# Build aset untuk produksi
npm run build
```
*Tips: Jika sedang mengembangkan tampilan, jalankan `npm run dev` untuk hot-reload.*

### 7. Jalankan Server Lokal
```bash
php artisan serve
```
Buka browser dan akses: `http://127.0.0.1:8000`

---

## 🔑 Akun Demo (Default Seeder)

Setelah menjalankan `php artisan migrate --seed`, akun berikut siap digunakan untuk testing:

| Role | Email | Password | Hak Akses |
| :--- | :--- | :--- | :--- |
| **Admin / Pustakawan** | `admin@pustaka.test` | `password` | Akses penuh dashboard `/admin`, sirkulasi, buku, dan laporan |
| **Member / Anggota** | `bagas.prakoso@example.test` | `password` | Akses dashboard `/member`, peminjaman, dan riwayat |

---

## 📁 Struktur Folder & Arsitektur Kode

Project ini menerapkan pola **Clean Architecture / Fat Service, Skinny Controller** agar kode mudah dipahami, dites, dan dikembangkan:

```
perpustakaan_tobias/
├── app/
│   ├── Enums/                 # Enum status (BorrowingStatus, FineStatus, UserRole)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/         # Controller spesifik panel admin (Buku, Sirkulasi, Denda, Laporan)
│   │   │   ├── Member/        # Controller spesifik panel member (Koleksi, Pinjaman, Profil)
│   │   │   └── Auth/          # Login, Register, Logout
│   │   └── Requests/          # Form Request Validation (validasi input terpisah dari controller)
│   ├── Models/                # Model Eloquent dengan relasi & scope query
│   └── Services/              # 🧠 Core Business Logic (Service Layer)
│       ├── BorrowingService.php        # Logic validasi peminjaman, approval, batas waktu & kalkulasi denda
│       ├── BookCatalogService.php      # Logic pencarian, filter kategori, dan ketersediaan stok
│       └── LibrarySettingsService.php  # Konfigurasi tarif denda & durasi pinjam dinamis
├── database/
│   ├── migrations/            # Skema tabel database
│   └── seeders/               # Data dummy realistis (LibrarySeeder)
├── resources/
│   ├── css/app.css            # Setup Tailwind CSS v4 & custom token tema editorial
│   └── views/
│       ├── admin/             # View Blade halaman admin
│       ├── member/            # View Blade halaman member
│       ├── public/            # Halaman katalog terbuka & landing page
│       └── components/        # Reusable Blade components (layouts, navbar, badge, modal)
└── routes/
    └── web.php                # Definisi rute yang dikelompokkan rapi per role & middleware
```

### Mengapa menggunakan `app/Services/`?
Alih-alih menumpuk ratusan baris query dan kalkulasi matematika di dalam Controller, seluruh alur peminjaman buku dan hitungan denda dipusatkan di `BorrowingService.php`. Controller hanya bertugas menerima request HTTP, memanggil Service, dan mengembalikan response atau view. Pola ini membuat kode jauh lebih mudah diuji (*testable*) dan minim bug saat ada perubahan aturan perpustakaan.

---

## 🧪 Testing

Project sudah dilengkapi unit dan feature test otomatis menggunakan PHPUnit:
```bash
php artisan test
```

---

Dibuat dengan dedikasi oleh **Tobias** untuk portofolio UKK RPL & persiapan magang/PKL industri. Feedback dan saran sangat terbuka! 🚀
