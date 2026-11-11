<?php

namespace Database\Seeders;

use App\Enums\BorrowingStatus;
use App\Enums\FineStatus;
use App\Enums\UserRole;
use App\Models\Author;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Fine;
use App\Models\Publisher;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LibrarySeeder extends Seeder
{
    /** @var array<string, string> */
    private array $authorByBook = [
        'Laskar Pelangi' => 'Andrea Hirata',
        'Bumi Manusia' => 'Pramoedya Ananta Toer',
        'Cantik Itu Luka' => 'Eka Kurniawan',
        'Perahu Kertas' => 'Dee Lestari',
        'Pulang' => 'Leila S. Chudori',
        'Hujan' => 'Tere Liye',
        'Saman' => 'Ayu Utami',
        'Ronggeng Dukuh Paruk' => 'Ahmad Tohari',
        'Orang-Orang Bloomington' => 'Budi Darma',
        'Sejarah Indonesia Modern' => 'M.C. Ricklefs',
        'Madilog' => 'Tan Malaka',
        'Nusa Jawa: Silang Budaya' => 'Denys Lombard',
        'Api Sejarah Nusantara' => 'Ahmad Mansur Suryanegara',
        'Kosmos' => 'Carl Sagan',
        'Sapiens: Riwayat Singkat Umat Manusia' => 'Yuval Noah Harari',
        'Energi Terbarukan di Indonesia' => 'Tim Penyusun',
        'Clean Code' => 'Robert C. Martin',
        'Algoritma dan Pemrograman' => 'Rinaldi Munir',
        'Pemrograman Web dengan PHP dan MySQL' => 'Budi Raharjo',
        'Dasar-Dasar Ilmu Ekonomi' => 'Tim Penyusun',
        'Rich Dad Poor Dad' => 'Robert T. Kiyosaki',
        'Perekonomian Indonesia' => 'Dumairy',
        'Metode Penelitian Kuantitatif' => 'Sugiyono',
        'Belajar dan Faktor yang Mempengaruhinya' => 'Slameto',
        'Kamus Besar Bahasa Indonesia' => 'Badan Pengembangan dan Pembinaan Bahasa',
        'Tata Bahasa Baku Bahasa Indonesia' => 'Anton M. Moeliono',
        'Tafsir Al-Misbah Jilid 1' => 'M. Quraish Shihab',
        'Fiqih Sunnah Jilid 2' => 'Sayyid Sabiq',
        'Cerita Rakyat Nusantara' => 'Tim Penyusun',
        'Kecil-Kecil Punya Karya' => 'Tim Penyusun',
        'Sejarah Seni Rupa Indonesia' => 'Tim Penyusun',
        'Pedoman Penulisan Karya Ilmiah' => 'Tim Penyusun',
    ];

    /** @var array<int, array{0: string, 1: string, 2: string, 3: int, 4: int, 5: string}> */
    private array $books = [
        ['Laskar Pelangi', 'Fiksi', 'Bentang Pustaka', 2005, 529, 'Kisah sepuluh anak Belitung yang berjuang mendapat pendidikan layak di tengah keterbatasan.'],
        ['Bumi Manusia', 'Sastra', 'Hasta Mitra', 1980, 535, 'Kisah Minke pada akhir masa kolonial, tentang cinta, kelas sosial, dan kebangkitan kesadaran pribumi.'],
        ['Cantik Itu Luka', 'Fiksi', 'Gramedia Pustaka Utama', 2002, 520, 'Saga keluarga Dewi Ayu yang memikat, kelam, dan penuh kejutan sejarah.'],
        ['Perahu Kertas', 'Fiksi', 'Bentang Pustaka', 2009, 444, 'Dua anak muda berbagi mimpi dan harus memilih antara cita-cita dan perasaan.'],
        ['Pulang', 'Fiksi', 'Kepustakaan Populer Gramedia', 2013, 552, 'Kisah eksil politik 1965 dan generasi sesudahnya yang mencari jalan pulang.'],
        ['Hujan', 'Fiksi', 'Gramedia Pustaka Utama', 2018, 320, 'Lail dan Esok bertahan melewati bencana dan luka, dalam dunia yang terus berubah.'],
        ['Saman', 'Sastra', 'Kepustakaan Populer Gramedia', 1998, 200, 'Empat perempuan Jakarta dan seorang pemuda misterius di akhir Orde Baru.'],
        ['Ronggeng Dukuh Paruk', 'Sastra', 'Gramedia Pustaka Utama', 1982, 400, 'Srintil, ronggeng cilik, dan kisah duka sebuah dusun di pedalaman Jawa.'],
        ['Orang-Orang Bloomington', 'Sastra', 'Sinar Harapan', 1980, 175, 'Sebelas cerita pendek tentang kesepian orang Indonesia di kota kecil Amerika.'],
        ['Sejarah Indonesia Modern', 'Sejarah', 'Serambi Ilmu Semesta', 2008, 865, 'Uraian komprehensif sejarah Indonesia dari abad ke-13 hingga era reformasi.'],
        ['Madilog', 'Sejarah', 'Narasi', 2016, 564, 'Materialisme, dialektika, dan logika sebagai cara berpikir yang dibangun Tan Malaka dari penjara.'],
        ['Nusa Jawa: Silang Budaya', 'Sejarah', 'Gramedia Pustaka Utama', 1996, 640, 'Kajian Denys Lombard tentang jaringan Asia dan akar budaya Jawa.'],
        ['Api Sejarah Nusantara', 'Sejarah', 'Salamadani', 2013, 532, 'Rekonstruksi peran ulama dan santri dalam perjuangan kemerdekaan Indonesia.'],
        ['Kosmos', 'Sains', 'Kepustakaan Populer Gramedia', 2016, 488, 'Penjelajahan tentang alam semesta, evolusi bintang, dan tempat manusia di dalamnya.'],
        ['Sapiens: Riwayat Singkat Umat Manusia', 'Sains', 'Kepustakaan Populer Gramedia', 2017, 524, 'Rentang sejarah Homo sapiens dari pemburu-peramu hingga peradaban modern.'],
        ['Energi Terbarukan di Indonesia', 'Sains', 'Penerbit ITB', 2019, 288, 'Peta potensi dan tantangan transisi energi di Indonesia.'],
        ['Clean Code', 'Teknologi', 'Prentice Hall', 2008, 464, 'Prinsip dan praktik menulis kode yang mudah dibaca serta dipelihara.'],
        ['Algoritma dan Pemrograman', 'Teknologi', 'Informatika', 2011, 408, 'Dasar perancangan algoritma, struktur data, dan penyelesaian masalah secara sistematis.'],
        ['Pemrograman Web dengan PHP dan MySQL', 'Teknologi', 'Informatika', 2016, 356, 'Langkah praktis membangun aplikasi web dinamis dengan PHP dan MySQL.'],
        ['Dasar-Dasar Ilmu Ekonomi', 'Ekonomi', 'Rajawali Pers', 2004, 490, 'Pengantar mikro dan makroekonomi untuk mahasiswa tahun pertama.'],
        ['Rich Dad Poor Dad', 'Ekonomi', 'Gramedia Pustaka Utama', 1997, 256, 'Dua pola pikir tentang uang dan pengelolaan aset keluarga.'],
        ['Perekonomian Indonesia', 'Ekonomi', 'Erlangga', 2012, 380, 'Analisis kebijakan fiskal, moneter, dan pembangunan ekonomi nasional.'],
        ['Metode Penelitian Kuantitatif', 'Pendidikan', 'Alfabeta', 2013, 334, 'Prosedur penelitian kuantitatif dari perumusan masalah hingga pelaporan.'],
        ['Belajar dan Faktor yang Mempengaruhinya', 'Pendidikan', 'Rineka Cipta', 2010, 195, 'Kajian psikologis tentang proses belajar dan faktor pendukungnya.'],
        ['Kamus Besar Bahasa Indonesia', 'Bahasa', 'Balai Pustaka', 2016, 1700, 'Rujukan makna, ejaan, dan pemakaian kata dalam bahasa Indonesia.'],
        ['Tata Bahasa Baku Bahasa Indonesia', 'Bahasa', 'Balai Pustaka', 2017, 520, 'Pedoman baku tata bahasa Indonesia untuk penulisan formal.'],
        ['Tafsir Al-Misbah Jilid 1', 'Agama', 'Lentera Hati', 2000, 640, 'Penafsiran Al-Qur\'an dengan pendekatan bahasa dan konteks sosial.'],
        ['Fiqih Sunnah Jilid 2', 'Agama', 'Pustaka Al-Kautsar', 2006, 712, 'Pembahasan fikih ibadah dan muamalah berdasarkan dalil.'],
        ['Cerita Rakyat Nusantara', 'Buku Anak', 'Yudhistira', 2014, 180, 'Kumpulan cerita rakyat dari berbagai daerah dengan pesan moral.'],
        ['Kecil-Kecil Punya Karya', 'Buku Anak', 'Mizan', 2018, 160, 'Antologi cerita anak tentang persahabatan dan keberanian.'],
        ['Sejarah Seni Rupa Indonesia', 'Seni', 'Departemen Pendidikan', 1979, 240, 'Catatan perkembangan seni rupa Indonesia dari masa klasik hingga modern.'],
        ['Pedoman Penulisan Karya Ilmiah', 'Referensi', 'Universitas Negeri Malang', 2019, 210, 'Panduan teknis penulisan karya ilmiah dan tata cara sitasi.'],
    ];

    public function run(): void
    {
        foreach (Setting::DEFAULTS as $key => $value) {
            Setting::put($key, $value);
        }

        $categories = collect([
            'Fiksi' => 'Prosa rekaan yang menghibur sekaligus membuka perspektif baru.',
            'Sastra' => 'Karya sastra Indonesia dan dunia yang menjadi rujukan.',
            'Sejarah' => 'Kajian sejarah nasional dan dunia.',
            'Sains' => 'Populer sains dan buku teks dasar.',
            'Teknologi' => 'Buku komputer, rekayasa, dan pemrograman.',
            'Ekonomi' => 'Ilmu ekonomi, keuangan, dan pembangunan.',
            'Pendidikan' => 'Teori pendidikan dan metode pengajaran.',
            'Bahasa' => 'Kamus, tata bahasa, dan keterampilan berbahasa.',
            'Agama' => 'Kajian keagamaan dan tafsir.',
            'Buku Anak' => 'Bacaan ringan untuk pembaca awal.',
            'Seni' => 'Seni rupa, musik, dan pertunjukan.',
            'Referensi' => 'Ensiklopedia, pedoman, dan buku rujukan.',
        ])->mapWithKeys(fn (string $description, string $name): array => [
            Str::slug($name) => Category::query()->create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $description,
            ]),
        ]);

        $publishers = collect(array_column($this->books, 2))
            ->unique()
            ->mapWithKeys(fn (string $name): array => [
                $name => Publisher::query()->create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'city' => null,
                ]),
            ]);

        $authors = collect($this->authorByBook)
            ->values()
            ->unique()
            ->mapWithKeys(fn (string $name): array => [
                $name => Author::query()->create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'bio' => $name === 'Tim Penyusun'
                        ? 'Kredit penulis belum diverifikasi; entri ini bersifat data contoh.'
                        : 'Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.',
                ]),
            ]);

        foreach ($this->books as $index => [$title, $categoryName, $publisherName, $year, $pages, $description]) {
            $copies = ($index % 4) + 2;
            $book = Book::query()->create([
                'title' => $title,
                'slug' => Str::slug($title).'-'.($index + 1),
                'isbn' => null,
                'category_id' => $categories[Str::slug($categoryName)]->id,
                'publisher_id' => $publishers[$publisherName]->id,
                'publication_year' => $year,
                'page_count' => $pages,
                'description' => $description,
                'total_copies' => $copies,
                'available_copies' => $copies,
                'is_featured' => $index % 6 === 0,
                'view_count' => 120 - $index * 3,
            ]);

            $book->authors()->attach($authors[$this->authorByBook[$title] ?? 'Tim Penyusun']);
        }

        $admin = User::query()->create([
            'name' => 'Rani Kusumawardhani',
            'email' => 'admin@pustaka.test',
            'password' => 'password',
            'role' => UserRole::Admin,
            'is_active' => true,
            'phone' => '081200000001',
            'address' => 'Jl. Kartini No. 8, Bandung',
            'joined_at' => now()->subYears(3),
            'email_verified_at' => now(),
        ]);

        $memberNames = [
            'Bagas Prakoso', 'Nadia Ayuningtyas', 'Fajar Ramadhan', 'Sinta Maharani',
            'Rizky Hidayat', 'Melati Putri', 'Yoga Pratama', 'Damar Wicaksono',
        ];

        $members = collect($memberNames)->map(fn (string $name, int $index): User => User::query()->create([
            'name' => $name,
            'email' => Str::slug($name, '.').'@example.test',
            'password' => 'password',
            'role' => UserRole::Member,
            'is_active' => $index !== 7,
            'phone' => '0813000000'.str_pad((string) $index, 2, '0', STR_PAD_LEFT),
            'address' => 'Jl. Merdeka No. '.($index + 3).', Bandung',
            'joined_at' => now()->subMonths($index + 1),
            'email_verified_at' => now(),
        ]));

        $approvedBooks = Book::query()->take(4)->get();
        foreach ($approvedBooks as $i => $book) {
            Borrowing::query()->create([
                'user_id' => $members[$i]->id,
                'book_id' => $book->id,
                'status' => BorrowingStatus::Approved->value,
                'requested_at' => now()->subDays(5),
                'approved_at' => now()->subDays(4),
                'due_at' => now()->addDays(3 - $i),
                'processed_by' => $admin->id,
            ]);
            $book->decrement('available_copies');
        }

        $lateBook = Book::query()->skip(5)->first();
        $late = Borrowing::query()->create([
            'user_id' => $members[4]->id,
            'book_id' => $lateBook->id,
            'status' => BorrowingStatus::Approved->value,
            'requested_at' => now()->subDays(20),
            'approved_at' => now()->subDays(19),
            'due_at' => now()->subDays(12),
            'processed_by' => $admin->id,
        ]);
        $lateBook->decrement('available_copies');

        Borrowing::query()->create([
            'user_id' => $members[5]->id,
            'book_id' => Book::query()->skip(6)->first()->id,
            'status' => BorrowingStatus::Requested->value,
            'requested_at' => now()->subHours(6),
            'member_note' => 'Untuk tugas akhir, mohon disetujui.',
        ]);

        Borrowing::query()->create([
            'user_id' => $members[1]->id,
            'book_id' => Book::query()->skip(7)->first()->id,
            'status' => BorrowingStatus::Rejected->value,
            'requested_at' => now()->subDays(3),
            'reject_reason' => 'Anggota masih memiliki pinjaman terlambat.',
            'processed_by' => $admin->id,
        ]);

        $returned = Borrowing::query()->create([
            'user_id' => $members[2]->id,
            'book_id' => Book::query()->skip(8)->first()->id,
            'status' => BorrowingStatus::Returned->value,
            'requested_at' => now()->subDays(30),
            'approved_at' => now()->subDays(29),
            'due_at' => now()->subDays(22),
            'returned_at' => now()->subDays(18),
            'processed_by' => $admin->id,
        ]);

        Fine::query()->create([
            'borrowing_id' => $returned->id,
            'user_id' => $members[2]->id,
            'days_late' => 4,
            'amount' => 4000,
            'status' => FineStatus::Unpaid,
        ]);

        $returnedPaid = Borrowing::query()->create([
            'user_id' => $members[3]->id,
            'book_id' => Book::query()->skip(9)->first()->id,
            'status' => BorrowingStatus::Returned->value,
            'requested_at' => now()->subDays(60),
            'approved_at' => now()->subDays(59),
            'due_at' => now()->subDays(52),
            'returned_at' => now()->subDays(50),
            'processed_by' => $admin->id,
        ]);

        Fine::query()->create([
            'borrowing_id' => $returnedPaid->id,
            'user_id' => $members[3]->id,
            'days_late' => 2,
            'amount' => 2000,
            'status' => FineStatus::Paid,
            'paid_at' => now()->subDays(49),
        ]);

        $late->load('book');
    }
}
