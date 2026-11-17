# 🏛️ DOKUMENTASI ARSITEKTUR SISTEM — PUSTAKA
**Sistem Informasi Perpustakaan Berbasis Web**  
*Materi Laporan & Presentasi Uji Kompetensi Keahlian (UKK) Rekayasa Perangkat Lunak (RPL)*

---

## 📌 Ringkasan Eksekutif

Aplikasi **Pustaka** dibangun dengan prinsip rekayasa perangkat lunak modern yang mengutamakan:
1. **Maintainability**: Kode terstruktur rapi, mudah dibaca, dan mudah diperluas di masa depan.
2. **Data Integrity**: Keamanan dan konsistensi data transaksi sirkulasi buku bebas dari *bug double-booking*.
3. **High Performance**: Respon server cepat dengan query database yang efisien serta antarmuka ringan tanpa beban *framework bloat*.

---

## 1. Konsep Arsitektur: MVC + Service Layer

Pada kurikulum standar SMK RPL, aplikasi web umumnya dibangun menggunakan pola **MVC (Model-View-Controller)** standar. Namun pada project Pustaka ini, arsitektur ditingkatkan dengan menambahkan **Service Layer** (*Fat Service, Skinny Controller*).

```
[ Request Browser ]
         │
         ▼
┌──────────────────┐
│   Form Request   │  ──► Menyaring dan memvalidasi input
└──────────────────┘
         │ (Input Valid)
         ▼
┌──────────────────┐
│    Controller    │  ──► Mengatur alur (Traffic Controller)
└──────────────────┘
         │
         ▼
┌──────────────────┐
│  Service Layer   │  ──► Mengeksekusi Logika Bisnis (Kalkulasi, DB Transaction, Lock)
└──────────────────┘
    │           │
    ▼           ▼
┌───────┐   ┌───────┐
│ Model │   │ Event │
└───────┘   └───────┘
    │
    ▼
┌──────────────────┐
│   Database MySQL │
└──────────────────┘
```

### Analogi Sederhana: "Restoran Modern"
Agar mudah dipahami oleh penguji, arsitektur ini dapat diibaratkan seperti sebuah restoran:
* **View (Piring Saji & Meja)**: Tampilan akhir makanan yang dinikmati pelanggan (antarmuka Blade template).
* **Controller (Pelayan / Waiter)**: Menerima pesanan dari pelanggan, memeriksa kelengkapan pesanan, lalu meneruskannya ke dapur. Controller **tidak memasak sendiri**.
* **Service Layer (Koki Profesional di Dapur)**: Tempat resep dan proses memasak sesungguhnya dijalankan. Koki memotong bahan, menimbang bumbu, dan memasak pesanan hingga matang.
* **Model & Database (Gudang Bahan Makanan)**: Tempat penyimpanan bahan baku (data tabel MySQL) yang diambil oleh koki saat memasak.

### Mengapa Menambahkan Service Layer? (Masalah *Fat Controller*)
Jika tidak menggunakan Service Layer, seluruh logika peminjaman (validasi keaktifan anggota, pengecekan limit kuota pinjam, pengurangan stok buku, pencatatan log) akan menumpuk di dalam Controller hingga ratusan baris. Akibatnya:
* Controller menjadi kotor, sulit dibaca, dan rawan salah ubah saat *maintenance*.
* Logika yang sama sulit digunakan kembali jika di masa depan ada fitur API mobile.

### Penerapan Nyata: `app/Services/BorrowingService.php`
Di project ini, Controller hanya bertugas 3-5 baris kode:
```php
// app/Http/Controllers/Member/BorrowingController.php
public function store(StoreBorrowingRequest $request, Book $book)
{
    $this->borrowingService->request($request->user(), $book, $request->input('member_note'));
    return back()->with('status', 'Permohonan peminjaman berhasil dikirim.');
}
```
Seluruh kalkulasi rumit dipindahkan ke `BorrowingService`:
1. Memverifikasi status keaktifan akun anggota.
2. Memeriksa kuota maksimal buku yang sedang dipinjam.
3. Mengurangi eksemplar buku yang tersedia secara aman.
4. Menghitung tanggal jatuh tempo (*due date*) sesuai pengaturan sistem.

### Service Layer Juga Membersihkan File Fisik (Anti *Storage Leak*)
Selain memisahkan logika bisnis, Service Layer di sini juga bertanggung jawab menjaga kebersihan penyimpanan file. Saat admin mengganti cover buku atau menghapus buku, file gambar lama tidak dibiarkan menumpuk di disk:
```php
// app/Services/BookCatalogService.php — saat mengganti cover
if ($newCoverPath !== null) {
    $oldCoverPath = $book->cover_path;
    $data['cover_path'] = $newCoverPath; // simpan path baru
}
// ... setelah buku tersimpan ...
if (isset($oldCoverPath) && $oldCoverPath !== null) {
    Storage::disk('public')->delete($oldCoverPath); // hapus file fisik lama
}

// Saat buku dihapus
if ($book->cover_path !== null) {
    Storage::disk('public')->delete($book->cover_path);
}
$book->delete();
```
Tanpa langkah `Storage::delete()` ini, setiap kali cover diubah atau buku dihapus akan menyisakan file yatim (*orphaned file*) di folder `storage/app/public/covers/` — lama-kelamaan memakan ruang disk tanpa guna. Ini disebut *storage/disk leak*, dan pencegahannya dipusatkan di satu tempat (Service) karena justru di sinilah aturan bisnis semacam ini seharusnya hidup.

---

## 2. Keamanan Data, Integritas, dan Validasi

Keamanan dan akurasi data sirkulasi perpustakaan adalah poin penilaian krusial dalam UKK RPL. Project ini menerapkan tiga lapis proteksi:

### A. Validasi Terisolasi via Form Request
Validasi data dipisahkan dari controller dengan membuat kelas turunan `Illuminate\Foundation\Http\FormRequest` (misalnya: `StoreBorrowingRequest`, `BookRequest`, `LoginRequest`).
* **Prinsip Kerja**: Validasi terjadi otomatis **sebelum** kode Controller dieksekusi.
* **Keuntungan**: Jika input tidak lolos validasi (misal: format tanggal salah, deskripsi kosong, file cover melebihi kapasitas), Laravel langsung mengembalikan respon error ke pengguna tanpa menyentuh database sama sekali.

### B. Konsistensi Data dengan Database Transaction (`DB::transaction`)
Dalam proses peminjaman dan pengembalian buku, sistem harus memperbarui lebih dari satu tabel secara serentak:
1. Memperbarui status di tabel `borrowings`.
2. Menambah/mengurangi stok `available_copies` di tabel `books`.
3. Menyimpan catatan riwayat di tabel `activity_logs`.

Dengan `DB::transaction()`, ketiga operasi di atas dijalankan sebagai **satu kesatuan (*Atomic*)**:
* Jika salah satu query gagal (misal koneksi server putus di langkah ke-2), seluruh perubahan sebelumnya otomatis dibatalkan (*Rollback*).
* Database tidak akan pernah berada dalam kondisi data timpang (misal: status peminjaman berubah, tapi stok buku gagal dikembalikan).

### C. Pencegahan Race Condition dengan Pessimistic Locking (`lockForUpdate`)
* **Studi Kasus Masalah**: Buku *Clean Code* hanya tersisa **1 eksemplar**. Dua siswa (Siswa A dan Siswa B) membuka halaman detail buku dan menekan tombol "Pinjam" pada detik yang persis sama.
* **Bahaya Tanpa Lock**: Kedua proses membaca bahwa stok masih `1`. Keduanya berhasil meminjam, dan stok buku berkurang menjadi `-1` (stok minus di dunia nyata mustahil terjadi).
* **Solusi di Pustaka**: Menggunakan `lockForUpdate()` pada level database MySQL:
```php
// app/Services/BorrowingService.php
return DB::transaction(function () use ($member, $book, $note): Borrowing {
    // Baris data buku dikunci sementara di database
    $lockedBook = Book::query()->lockForUpdate()->findOrFail($book->id);

    if ($lockedBook->available_copies < 1) {
        throw ValidationException::withMessages([
            'book' => 'Eksemplar buku sudah habis dipinjam.',
        ]);
    }

    // Eksekusi pinjam & pengurangan stok
    $lockedBook->decrement('available_copies');
    ...
});
```
* **Mekanisme**: Saat Siswa A memproses request, baris data buku di-lock secara eksklusif oleh MySQL. Request Siswa B harus menunggu sepersekian milidetik hingga transaksi Siswa A selesai. Saat giliran Siswa B dieksekusi, sistem mendeteksi stok sudah `0` dan otomatis menolak permohonan dengan pesan yang valid.

### D. Studi Kasus: Penghapusan Akun Anggota (`MemberAccountService::delete()`)
Fitur "hapus akun" terdengar sepele — cukup `$user->delete()`. Tapi di database relasional, satu baris user bisa "ditembak" oleh tabel lain. Karena itu penghapusan akun di Pustaka melewati dua lapis pengamanan:

**1. Proteksi Foreign Key & Audit Trail**
Tabel `borrowings` memakai constraint `restrictOnDelete()` — artinya MySQL akan **menolak** penghapusan user yang masih direferensikan di tabel tersebut. Kalau kita hapus langsung tanpa cek, aplikasi bukan menghapus data, melainkan **crash** dengan `QueryException`.
Solusinya, Service mengecek riwayat lebih dulu:
```php
// app/Services/MemberAccountService.php
if ($member->borrowings()->exists()) {
    throw ValidationException::withMessages([
        'member' => 'Anggota tidak dapat dihapus karena memiliki riwayat peminjaman. Gunakan opsi nonaktifkan akun.',
    ]);
}

$name = $member->name;
$member->forceDelete();

// Dicatat SETELAH data dihapus, tapi nama sudah disimpan lebih dulu
ActivityLog::record('member.deleted', "Akun anggota {$name} dihapus permanen.");
```
Dua hal penting di sini:
* **Riwayat transaksi tetap utuh.** Peminjaman adalah bukti akuntabilitas perpustakaan; menghapusnya demi "merapikan" data anggota justru merusak laporan.
* **Audit trail tidak ikut hilang.** Nama anggota disimpan ke variabel `$name` *sebelum* `forceDelete()`, karena setelah baris user lenyap tidak ada lagi data yang bisa dibaca untuk menulis log. Log `member.deleted` mencatat siapa admin yang menghapus dan siapa yang dihapus.

**2. Concurrency Guard (Anti Race Condition)**
Skenario jahat: admin menekan "Hapus akun" pada detik yang sama ketika anggota tersebut menekan "Ajukan peminjaman". Tanpa pengamanan, pengecekan riwayat bisa lolos (karena peminjaman belum tersimpan), lalu penghapusan jalan — dan request peminjaman yang menyusul menabrak user yang sudah tidak ada.
Karena itu seluruh proses dibungkus transaksi dan baris user dikunci:
```php
return DB::transaction(function () use ($member): void {
    $member = User::query()->lockForUpdate()->findOrFail($member->id);
    // cek role -> cek riwayat -> forceDelete
});
```
Dengan `lockForUpdate()`, request peminjaman yang datang bersamaan akan **menunggu** sampai transaksi hapus selesai. Begitu gilirannya tiba, user sudah tidak ada sehingga permohonan otomatis gagal dengan pesan yang jelas — bukan data yatim (*orphan*) di database.

---

## 3. Desain Frontend: Filosofi Editorial Brutalist

Alih-alih menggunakan template dashboard generik berbasis Bootstrap atau menambahkan framework JavaScript berat (seperti React, Vue, atau Livewire), frontend Pustaka dirancang dengan pendekatan **Server-Side Rendered (SSR) murni**.

### A. Mengapa Tanpa Framework JS Berat?
1. **Performa & Waktu Muat Cepat**: Browser tidak perlu mengunduh file bundle JS berukuran megabyte sebelum halaman bisa ditampilkan. Server menyajikan HTML matang yang langsung siap dirender.
2. **Kesesuaian Kebutuhan**: Aplikasi perpustakaan didominasi oleh operasi formulir, tabel data, dan pembacaan katalog. Kebutuhan interaktivitas mikro (seperti modal popup konfirmasi atau menu navigasi mobile) cukup ditangani oleh **Alpine.js** yang sangat ringan (< 15 KB).
3. **Mudah Dipelihara**: Tidak ada komplikasi state-management rumit di sisi client; source of truth tetap berada di backend Laravel.

### B. Desain Gaya "Editorial Brutalist"
Identitas visual Pustaka memadukan keanggunan tata letak majalah/surat kabar (**Editorial**) dengan ketegasan struktur modern (**Brutalisme**):
* **Tipografi Kontras Berkarakter**:
  * **Playfair Display (Serif)**: Digunakan untuk tajuk utama (*headings*), mencerminkan wibawa literatur buku dan kesan klasik perpustakaan.
  * **Inter (Sans-Serif)**: Digunakan untuk angka data, teks isi, dan form input demi keterbacaan (*readability*) maksimal.
* **Border Tegas & Grid Rapi**: Menggunakan garis pemisah nyata (`border border-black` / `border-line`), palet warna monokrom berlatar kertas bersih (`#ffffff` dan `#e8e5df`), serta aksen warna merah tua/crimson (`#9d3327`) untuk status penting.
* **Tailwind CSS v4 Native**: Menggunakan arsitektur utility Tailwind v4 terbaru dengan konfigurasi tema `@theme` langsung di CSS tanpa file konfigurasi `tailwind.config.js` yang usang.
* **Cover Buku: Placeholder Garis Silang (X)**: Komponen `<x-book-cover>` dipakai seragam dari tabel admin, form, kartu katalog, sampai halaman detail. Jika buku belum punya gambar, alih-alih memakai kotak kosong yang membosankan atau warna acak, komponen menampilkan kotak kaku `border-black` dengan dua garis diagonal silang (X) via SVG serta inisial judul berfont Playfair Display. Hasilnya: setiap cover selalu punya "bentuk" yang tegas dan tingginya konsisten sehingga layout tidak runtuh meski sebagian data tanpa gambar.
* **Modal Konfirmasi Destruktif (Alpine.js + Brutalist)**: Aksi berbahaya seperti hapus akun tidak pernah dieksekusi lewat satu klik. Tombol `HAPUS AKUN` hanya membuka modal Alpine (`x-data="{ confirmDelete: false }"`) yang bisa ditutup dengan tombol Batal, klik di luar area (`@click.outside`), atau tombol `Esc` (`@keydown.escape.window`). Gayanya tetap kaku: `rounded-none`, `border-red-700`/`bg-red-700`, teks Inter `uppercase tracking-widest`, tanpa shadow — merah tegas dipakai khusus untuk sinyal bahaya tanpa merusak palet monokrom halaman.

---

## 4. Optimasi Performa Database & Manajemen Memori

Aplikasi dirancang agar tetap responsif meskipun data anggota, buku, dan transaksi peminjaman telah berkembang menjadi ribuan baris:

### A. Mengatasi Masalah "N+1 Query" dengan Eager Loading
Masalah paling umum pada aplikasi pemula adalah **N+1 Query Problem**, di mana aplikasi menjalankan 1 query untuk mengambil daftar buku, lalu mengeksekusi 1 query tambahan untuk setiap buku demi mencari nama penulisnya.
* Jika ada 50 buku di katalog, sistem akan mengeksekusi **51 query** ke database, membuat server lambat dan boros resource.

**Solusi di Project Pustaka**: Menggunakan **Eager Loading** (`with()`):
```php
// app/Http/Controllers/CatalogController.php
$books = Book::query()
    ->with(['authors', 'category', 'publisher']) // Eager Loading
    ->paginate(12);
```
Dengan satu baris `with(['authors', 'category', 'publisher'])`, Laravel secara pintar hanya mengeksekusi **2-3 query terpadu** menggunakan klausa `WHERE IN (...)`, berapapun jumlah buku yang ditampilkan di halaman.

### B. Manajemen Memori dengan Pagination
Mengambil seluruh data menggunakan `->get()` atau `->all()` pada tabel transaksi adalah kesalahan fatal karena dapat menyebabkan kehabisan memori server (*Out of Memory*).

Project ini menerapkan pagination terkontrol di seluruh modul admin dan member:
* **Halaman Riwayat Anggota (`Member/HistoryController.php`)**:
  Hanya menampilkan transaksi selesai (`returned`, `rejected`, `cancelled`) sebanyak 10 baris per halaman:
  ```php
  $borrowings = $request->user()->borrowings()
      ->with('book.authors')
      ->whereIn('status', ['returned', 'rejected', 'cancelled'])
      ->latest('updated_at')
      ->paginate(10);
  ```
  Dengan begitu halaman riwayat tetap ringan meskipun anggota sudah pernah meminjam ratusan buku.

---

## 5. Clean Code & Type Safety (Standar Industri)

Dua kebiasaan kecil yang jarang disadari pelajar, tetapi sangat diperhatikan oleh developer magang/PKL:

### A. PHP Enums — Menggantikan "Magic Strings" agar Type-Safe
Pada tutorial dasar, status peminjaman biasanya ditulis sebagai teks biasa (*magic string*) yang tersebar di sana-sini, misalnya `where('status', 'approved')` di satu file dan `'Approvved'` (salah ketik) di file lain. Sekali salah tulis, bug-nya sangat sulit dilacak karena PHP tidak akan memberi peringatan apa pun.
Project ini memusatkan semua status dan peran ke dalam **PHP Enum**:
```php
// app/Enums/BorrowingStatus.php
enum BorrowingStatus: string
{
    case Requested = 'requested';
    case Approved = 'approved';
    case Returned = 'returned';
    // ...
}

// app/Enums/UserRole.php
enum UserRole: string
{
    case Admin = 'admin';
    case Member = 'member';
}
```
Pemakaiannya di query juga mengandalkan Enum, bukan teks langsung:
```php
Borrowing::query()->where('status', BorrowingStatus::Approved)->count();
```
Keuntungannya:
* **Type-safe**: Kalau salah menulis `BorrowingStatus::Approvved`, editor akan langsung menampilkan error sebelum aplikasi dijalankan.
* **Satu sumber kebenaran (*single source of truth*)**: Semua nilai 'approved', 'returned', dan sebagainya dikelola di satu tempat.

### B. Automated Code Styling dengan Laravel Pint (PSR-12)
Kerapian spasi, letak kurung kurawal, dan urutan `use` import tidak perlu dirapikan manual satu per satu. Project memanfaatkan **Laravel Pint** — formatter otomatis yang sudah tersedia bawaan Laravel:
```bash
vendor/bin/pint
```
Satu perintah ini langsung merapikan seluruh kode agar konsisten mengikuti standar **PSR-12** (konvensi penulisan PHP yang diakui industri), tanpa mengubah logika program sedikit pun. Karena dijalankan otomatis, seluruh anggota tim (atau versi AI coding-agent) menghasilkan gaya kode yang sama persis, sehingga hasil review kode (code review) jauh lebih bersih.

---

## 6. Ringkasan Poin Kunci untuk Penguji UKK

Saat mempresentasikan arsitektur ini di depan guru penguji atau asesor industri:

| Topik Pertanyaan Penguji | Jawaban Kunci Berbasis Arsitektur Ini |
| :--- | :--- |
| **"Kenapa pakai Service Layer, tidak langsung di Controller?"** | Memisahkan tanggung jawab kode (*Separation of Concerns*). Controller hanya menangani request/response (Skinny), sementara aturan bisnis sirkulasi terpusat di Service (Fat) sehingga mudah di-unit test dan tidak redundan. |
| **"Bagaimana jika ada 2 user pinjam buku terakhir bersamaan?"** | Sistem menggunakan `DB::transaction()` dipadukan dengan `lockForUpdate()` di MySQL. User kedua akan terkunci (*pessimistic lock*) sampai transaksi pertama selesai, sehingga stok tidak akan pernah minus (*race condition safe*). |
| **"Apakah aplikasinya lambat jika datanya ribuan?"** | Tidak, karena query relasi dioptimasi menggunakan Eager Loading (`with()`) untuk mematikan N+1 query problem, dan seluruh data disajikan menggunakan Pagination terukur. |
| **"Kenapa memilih Blade + Tailwind daripada React/Vue?"** | Untuk arsitektur perpustakaan, Server-Side Rendering (SSR) memberikan *First Contentful Paint* (FCP) instan tanpa overhead download JS ratusan kilobyte. Tampilan unik dicapai lewat prinsip desain Editorial Brutalist yang efisien. |

---

*Dokumen disusun oleh **Tobias** — Rekayasa Perangkat Lunak (RPL).*
