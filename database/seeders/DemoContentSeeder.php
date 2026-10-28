<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\OrganizationProfile;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DemoContentSeeder extends Seeder
{
    /**
     * Seed akun admin, profil organisasi, dan publikasi contoh.
     *
     * Seeder ini idempoten: aman dijalankan berulang kali tanpa
     * menggandakan data.
     */
    public function run(): void
    {
        $this->call(CategorySeeder::class);

        $admin = $this->seedAdmin();
        $this->seedOrganization();
        $this->seedPublications($admin);
    }

    /**
     * Akun admin default.
     */
    protected function seedAdmin(): User
    {
        return User::updateOrCreate(
            ['email' => 'admin@fpui.com'],
            [
                'name' => 'Administrator FPUI',
                'password' => 'password123',
                'role' => 'admin',
                'must_change_password' => false,
                'email_verified_at' => now(),
            ]
        );
    }

    /**
     * Profil organisasi (satu baris).
     */
    protected function seedOrganization(): void
    {
        $logo = 'organization/rzQFLKo3waCiZN2njfrAHuc1KqEXEJTzo5wNgPce.png';

        OrganizationProfile::firstOrCreate(
            ['slug' => Str::slug('Forum Perpustakaan Umum Indonesia')],
            [
                'name' => 'Forum Perpustakaan Umum Indonesia',
                'logo' => $logo,
                'description' => 'Forum Perpustakaan Umum Indonesia (FPUI) merupakan forum nasional yang menghimpun perpustakaan umum di seluruh Indonesia. FPUI berperan sebagai wadah komunikasi, kolaborasi, dan penguatan jejaring antar pengelola perpustakaan umum dalam rangka meningkatkan kualitas layanan literasi masyarakat dan pengembangan perpustakaan di tingkat daerah maupun nasional.',
                'about' => '<p>FPUI berdiri sebagai forum yang mempertemukan pengelola perpustakaan umum dari berbagai daerah. Forum ini menjadi ruang berbagi praktik baik, pengembangan kapasitas sumber daya manusia, serta advokasi kebijakan yang mendukung tumbuhnya budaya literasi.</p><p>Melalui program jejaring, pelatihan, dan publikasi, FPUI mendorong perpustakaan umum agar semakin dekat dengan masyarakat dan mampu menjawab kebutuhan informasi di era digital.</p>',
                'vision' => '<p>Menjadi forum nasional yang mendorong perpustakaan umum Indonesia sebagai pusat literasi, informasi, dan inklusi sosial yang berdaya saing.</p>',
                'mission' => '<ol><li>Memperkuat jejaring dan kolaborasi antar perpustakaan umum di seluruh Indonesia.</li><li>Meningkatkan kompetensi dan profesionalisme pengelola perpustakaan umum.</li><li>Mendorong inovasi layanan yang inklusif dan berbasis kebutuhan masyarakat.</li><li>Mengadvokasi kebijakan yang mendukung pengembangan perpustakaan umum.</li></ol>',
                'email' => 'sekretariat@fpui.or.id',
                'phone' => '021-0000000',
                'address' => 'Jakarta, Indonesia',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Pusat',
                'postal_code' => '10110',
                'instagram' => 'https://www.instagram.com/fpui.official',
                'facebook' => null,
                'youtube' => null,
            ]
        );
    }

    /**
     * Publikasi contoh (artikel & berita).
     */
    protected function seedPublications(User $admin): void
    {
        foreach ($this->publications() as $index => $item) {
            $category = Category::where('slug', Str::slug($item['category']))->first();

            $publication = Publication::firstOrNew(['title' => $item['title']]);

            if (! $publication->exists) {
                $publication->slug = $this->uniqueSlug($item['title']);
            }

            $timestamp = Carbon::parse($item['date'])->setTime(9 + ($index % 8), 0);

            $publication->fill([
                'user_id' => $admin->id,
                'category_id' => $category?->id,
                'title' => $item['title'],
                'content' => $this->content($item),
                'type' => $item['type'],
                'status' => 'published',
                'thumbnail' => null,
                'attachment' => null,
                'show_on_banner' => $item['featured'] ?? false,
                'expired_at' => null,
            ]);

            $publication->created_at = $timestamp;
            $publication->updated_at = $timestamp;
            $publication->save();
        }
    }

    /**
     * Susun konten HTML dari lead dan paragraf.
     *
     * @param  array<string, mixed>  $item
     */
    protected function content(array $item): string
    {
        $html = '<h2>'.$item['lead'].'</h2>';

        foreach ($item['paragraphs'] as $paragraph) {
            $html .= '<p>'.$paragraph.'</p>';
        }

        $html .= '<p>Informasi lebih lanjut mengenai kegiatan ini dapat diperoleh melalui sekretariat FPUI.</p>';

        return $html;
    }

    /**
     * Slug unik mengikuti pola yang dipakai controller admin.
     */
    protected function uniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $count = Publication::where('slug', 'LIKE', $slug.'%')->count();

        return $count ? $slug.'-'.($count + 1) : $slug;
    }

    /**
     * Daftar publikasi contoh.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function publications(): array
    {
        return [
            [
                'title' => 'Transformasi Digital Perpustakaan Umum di Era Digitalisasi',
                'type' => 'article',
                'category' => 'Teknologi',
                'date' => '2026-09-30',
                'featured' => true,
                'lead' => 'Latar Belakang dan Urgensi Transformasi',
                'paragraphs' => [
                    'Perpustakaan umum di Indonesia menghadapi tekanan untuk beradaptasi terhadap perubahan perilaku pemustaka yang kini lebih banyak mengakses informasi melalui kanal digital. Transformasi digital bukan sekadar pengadaan perangkat, tetapi perubahan cara layanan dirancang dan disampaikan kepada masyarakat.',
                    'FPUI menilai diperlukan peta jalan yang jelas: digitalisasi koleksi, penguatan kompetensi pustakawan, penyediaan layanan daring, serta integrasi data antar perpustakaan daerah agar layanan menjadi lebih mudah diakses.',
                    'Melalui kolaborasi lintas daerah, transformasi dapat berjalan bertahap tanpa meninggalkan perpustakaan yang memiliki keterbatasan sumber daya.',
                ],
            ],
            [
                'title' => 'FPUI Luncurkan Program Advokasi Literasi 2026',
                'type' => 'news',
                'category' => 'Pendidikan',
                'date' => '2026-09-30',
                'lead' => 'Latar Belakang Program',
                'paragraphs' => [
                    'FPUI resmi meluncurkan Program Advokasi Literasi 2026 sebagai upaya memperkuat posisi perpustakaan umum dalam pembangunan literasi masyarakat. Program ini menyasar daerah dengan capaian literasi yang masih perlu ditingkatkan.',
                    'Rangkaian kegiatan mencakup pendampingan penyusunan program literasi daerah, pelatihan pengelola perpustakaan, serta kampanye publik untuk mendorong kebiasaan membaca sejak dini.',
                    'Program akan dievaluasi secara berkala bersama pemerintah daerah dan mitra jejaring perpustakaan.',
                ],
            ],
            [
                'title' => 'Workshop Digitalisasi Koleksi untuk Perpustakaan Daerah',
                'type' => 'news',
                'category' => 'Teknologi',
                'date' => '2026-09-25',
                'lead' => 'Fasilitas Workshop',
                'paragraphs' => [
                    'Sebanyak puluhan pengelola perpustakaan daerah mengikuti workshop digitalisasi koleksi yang diselenggarakan FPUI. Peserta memperoleh materi mengenai alur kerja pemindaian, penamaan berkas, metadata, hingga penyajian koleksi digital.',
                    'Workshop menekankan pentingnya standar metadata agar koleksi digital mudah ditemukan kembali dan dapat diintegrasikan dengan sistem perpustakaan lain.',
                    'Peserta diharapkan menjadi penggerak digitalisasi di daerah masing-masing setelah kembali ke instansi asal.',
                ],
            ],
            [
                'title' => 'Strategi Literasi Informasi untuk Masyarakat Indonesia',
                'type' => 'article',
                'category' => 'Pendidikan',
                'date' => '2026-09-25',
                'lead' => 'Mengapa Literasi Informasi Penting',
                'paragraphs' => [
                    'Literasi informasi membantu masyarakat menilai kebenaran, relevansi, dan kredibilitas informasi yang diterima setiap hari. Tanpa kemampuan ini, banjir informasi digital berpotensi menimbulkan kebingungan dan polarisasi.',
                    'Perpustakaan umum dapat berperan sebagai simpul pembelajaran literasi informasi melalui pelatihan pencarian sumber, verifikasi fakta, serta pendampingan penggunaan basis data ilmiah.',
                    'FPUI mendorong setiap perpustakaan menyusun modul literasi informasi yang kontekstual sesuai kebutuhan komunitas di sekitarnya.',
                ],
            ],
            [
                'title' => 'FPUI Adopsi Standar Metadata Perpustakaan Nasional',
                'type' => 'news',
                'category' => 'Teknologi',
                'date' => '2026-09-21',
                'lead' => 'Penerapan Standar Baru',
                'paragraphs' => [
                    'FPUI menyatakan komitmen untuk mengadopsi standar metadata yang dikeluarkan Perpustakaan Nasional dalam pengelolaan katalog koleksi. Standar ini menjadi acuan agar data koleksi antar perpustakaan dapat saling terhubung.',
                    'Sosialisasi standar akan dilakukan bertahap melalui seri pelatihan daring dan pendampingan teknis bagi perpustakaan daerah.',
                    'Dengan keseragaman metadata, layanan penelusuran koleksi lintas perpustakaan menjadi lebih mudah diwujudkan.',
                ],
            ],
            [
                'title' => 'Peran Pustakawan dalam Membangun Pustaka Inklusif',
                'type' => 'article',
                'category' => 'Umum',
                'date' => '2026-09-20',
                'lead' => 'Prinsip Keterjangkauan Layanan',
                'paragraphs' => [
                    'Pustaka inklusif memastikan seluruh anggota masyarakat memperoleh akses yang setara terhadap koleksi dan layanan, termasuk penyandang disabilitas, anak-anak, dan kelompok marjinal.',
                    'Pustakawan berperan penting dalam menata ruang, memilih koleksi, dan merancang kegiatan yang ramah bagi semua kalangan. Penyesuaian sederhana seperti penataan rak yang mudah dijangkau dan penyediaan koleksi braille memberikan dampak besar.',
                    'FPUI mengajak perpustakaan umum menjadikan inklusi sebagai prinsip dasar, bukan program tambahan.',
                ],
            ],
            [
                'title' => 'Rapat Koordinasi Nasional Pengelola Perpustakaan Umum 2026',
                'type' => 'news',
                'category' => 'Umum',
                'date' => '2026-09-15',
                'lead' => 'Agenda Koordinasi',
                'paragraphs' => [
                    'Rapat koordinasi nasional mempertemukan pengelola perpustakaan umum dari berbagai provinsi untuk menyelaraskan program kerja dan indikator capaian tahun berjalan.',
                    'Peserta membahas penguatan jejaring daerah, pendataan koleksi, serta rencana kegiatan bersama pada semester berikutnya.',
                    'Hasil koordinasi dituangkan dalam rencana aksi yang akan dipantau secara berkala oleh sekretariat FPUI.',
                ],
            ],
            [
                'title' => 'Meningkatkan Minat Baca Melalui Program Pojok Baca Digital',
                'type' => 'article',
                'category' => 'Pendidikan',
                'date' => '2026-09-10',
                'lead' => 'Pojok Baca di Ruang Publik',
                'paragraphs' => [
                    'Pojok baca digital menghadirkan koleksi elektronik dan akses internet di ruang publik seperti taman, balai desa, dan pusat kegiatan masyarakat. Pendekatan ini mendekatkan perpustakaan kepada calon pemustaka yang belum terbiasa datang ke gedung perpustakaan.',
                    'Keberhasilan program ditentukan oleh ketersediaan koleksi yang relevan, pendampingan relawan, dan jadwal layanan yang konsisten.',
                    'FPUI mendorong perpustakaan umum menjajaki kerja sama dengan pemerintah daerah untuk memperluas jangkauan layanan.',
                ],
            ],
            [
                'title' => 'Kunjungan Studi Tiru Perpustakaan Umum Kota Surabaya',
                'type' => 'news',
                'category' => 'Umum',
                'date' => '2026-09-05',
                'lead' => 'Praktik Baik yang Dipelajari',
                'paragraphs' => [
                    'Delegasi FPUI melakukan kunjungan studi tiru ke perpustakaan umum Kota Surabaya untuk mempelajari pengelolaan layanan, tata ruang, dan program literasi yang berjalan baik.',
                    'Delegasi mencatat sejumlah praktik yang dapat diadaptasi, antara lain layanan ramah anak, penataan koleksi tematik, dan kemitraan dengan komunitas lokal.',
                    'Hasil kunjungan akan dirangkum sebagai bahan rekomendasi bagi perpustakaan daerah lain.',
                ],
            ],
            [
                'title' => 'Membangun Layanan Perpustakaan Ramah Anak',
                'type' => 'article',
                'category' => 'Pendidikan',
                'date' => '2026-08-28',
                'lead' => 'Ruang yang Aman dan Menyenangkan',
                'paragraphs' => [
                    'Layanan ramah anak menuntut perhatian pada keamanan ruang, kenyamanan furnitur, serta koleksi yang sesuai tahap perkembangan anak.',
                    'Selain fasilitas, pendampingan pustakawan dan kegiatan bercerita terbukti meningkatkan keterlibatan anak terhadap layanan perpustakaan.',
                    'FPUI menyiapkan panduan sederhana bagi perpustakaan yang ingin mengembangkan layanan serupa secara bertahap.',
                ],
            ],
            [
                'title' => 'Pelatihan Katalogisasi Bahan Pustaka bagi Pengelola Daerah',
                'type' => 'news',
                'category' => 'Pendidikan',
                'date' => '2026-08-22',
                'lead' => 'Materi Pelatihan',
                'paragraphs' => [
                    'Pelatihan katalogisasi diikuti pengelola perpustakaan daerah dengan materi penentuan titik akses, penulisan deskripsi bibliografi, dan klasifikasi koleksi.',
                    'Peserta berlatih langsung menggunakan contoh bahan pustaka sehingga dapat menerapkan pengetahuan pada koleksi di instansinya.',
                    'Kegiatan ini merupakan bagian dari program penguatan kapasitas sumber daya manusia perpustakaan umum.',
                ],
            ],
            [
                'title' => 'Optimalisasi Media Sosial untuk Promosi Layanan Perpustakaan',
                'type' => 'article',
                'category' => 'Bisnis',
                'date' => '2026-08-18',
                'lead' => 'Menjangkau Pemustaka Baru',
                'paragraphs' => [
                    'Media sosial menjadi kanal efektif untuk memperkenalkan koleksi dan kegiatan perpustakaan kepada masyarakat yang lebih luas.',
                    'Perencanaan konten yang konsisten, pemilihan format visual, dan interaksi dengan audiens menjadi kunci keberhasilan promosi layanan.',
                    'Perpustakaan perlu menetapkan indikator sederhana agar upaya promosi dapat dievaluasi secara objektif.',
                ],
            ],
            [
                'title' => 'FPUI Jalin Kerja Sama dengan Perpustakaan Nasional RI',
                'type' => 'news',
                'category' => 'Umum',
                'date' => '2026-08-12',
                'lead' => 'Ruang Lingkup Kerja Sama',
                'paragraphs' => [
                    'FPUI dan Perpustakaan Nasional RI menyepakati kerja sama dalam pengembangan kapasitas pengelola perpustakaan umum serta penguatan program literasi nasional.',
                    'Kerja sama mencakup pelatihan bersama, pemanfaatan sumber belajar digital, dan dukungan teknis bagi perpustakaan daerah.',
                    'Kedua pihak akan membentuk tim koordinasi untuk memastikan program berjalan sesuai kesepakatan.',
                ],
            ],
            [
                'title' => 'Pengelolaan Arsip Digital di Perpustakaan Umum',
                'type' => 'article',
                'category' => 'Teknologi',
                'date' => '2026-08-05',
                'lead' => 'Dari Fisik ke Digital',
                'paragraphs' => [
                    'Arsip digital memungkinkan perpustakaan menyimpan dokumen penting secara lebih aman dan mudah diakses kembali. Namun, tanpa tata kelola yang baik, arsip digital justru berisiko hilang atau sulit ditemukan.',
                    'Diperlukan kebijakan penyimpanan, penamaan berkas yang konsisten, serta pencadangan berkala agar data tetap terjaga.',
                    'FPUI mendorong perpustakaan menyusun prosedur sederhana sebelum memulai program digitalisasi arsip.',
                ],
            ],
            [
                'title' => 'Lomba Resensi Buku Tingkat Nasional 2026',
                'type' => 'news',
                'category' => 'Pendidikan',
                'date' => '2026-07-30',
                'lead' => 'Kategori dan Ketentuan',
                'paragraphs' => [
                    'Lomba resensi buku tingkat nasional kembali digelar dengan kategori pelajar, mahasiswa, dan umum. Peserta menuliskan resensi atas buku yang tersedia di perpustakaan umum.',
                    'Kegiatan ini bertujuan menumbuhkan kebiasaan membaca kritis serta memperkenalkan koleksi perpustakaan kepada masyarakat.',
                    'Karya terbaik akan dipublikasikan melalui kanal resmi FPUI.',
                ],
            ],
            [
                'title' => 'Perpustakaan Keliling sebagai Solusi Akses Literasi',
                'type' => 'article',
                'category' => 'Umum',
                'date' => '2026-07-24',
                'lead' => 'Menjangkau Wilayah Terpencil',
                'paragraphs' => [
                    'Perpustakaan keliling menjadi salah satu solusi bagi wilayah yang belum memiliki gedung perpustakaan tetap. Layanan ini membawa koleksi langsung ke sekolah, pasar, dan permukiman warga.',
                    'Efektivitas layanan bergantung pada jadwal kunjungan yang teratur, kondisi kendaraan, serta keterlibatan pemerintah daerah dalam pembiayaan operasional.',
                    'FPUI menyarankan integrasi layanan keliling dengan program literasi sekolah agar dampaknya lebih terasa.',
                ],
            ],
            [
                'title' => 'Sosialisasi Standar Akreditasi Perpustakaan Umum',
                'type' => 'news',
                'category' => 'Umum',
                'date' => '2026-07-18',
                'lead' => 'Persiapan Akreditasi',
                'paragraphs' => [
                    'Sosialisasi standar akreditasi diikuti pengelola perpustakaan umum untuk memahami komponen penilaian dan bukti dukung yang diperlukan.',
                    'Peserta memperoleh penjelasan mengenai penyusunan dokumen, evaluasi layanan, serta perbaikan berkelanjutan.',
                    'Pendampingan lanjutan akan disediakan bagi perpustakaan yang akan mengajukan akreditasi.',
                ],
            ],
            [
                'title' => 'Mendorong Kolaborasi Sekolah dan Perpustakaan Umum',
                'type' => 'article',
                'category' => 'Pendidikan',
                'date' => '2026-07-10',
                'lead' => 'Sinergi Layanan Literasi',
                'paragraphs' => [
                    'Kolaborasi antara sekolah dan perpustakaan umum memperluas akses siswa terhadap koleksi dan kegiatan literasi di luar jam sekolah.',
                    'Bentuk kerja sama dapat berupa kunjungan kelas, program membaca bersama, maupun pemanfaatan koleksi perpustakaan umum sebagai sumber belajar.',
                    'FPUI mendorong kesepakatan kerja sama yang jelas agar manfaatnya berkelanjutan.',
                ],
            ],
            [
                'title' => 'Evaluasi Program Literasi Semester I 2026',
                'type' => 'news',
                'category' => 'Umum',
                'date' => '2026-07-02',
                'lead' => 'Capaian dan Catatan',
                'paragraphs' => [
                    'Evaluasi semester pertama menunjukkan peningkatan partisipasi masyarakat pada kegiatan literasi di sejumlah daerah, meski sebarannya belum merata.',
                    'Beberapa kendala yang tercatat antara lain keterbatasan tenaga pengelola, anggaran operasional, dan sarana pendukung.',
                    'Rekomendasi evaluasi menjadi dasar penyusunan rencana kegiatan semester berikutnya.',
                ],
            ],
        ];
    }
}
