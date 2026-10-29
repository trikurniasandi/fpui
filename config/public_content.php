<?php

/*
|--------------------------------------------------------------------------
| Konten Halaman Statis
|--------------------------------------------------------------------------
|
| Semua teks pada halaman organisasi, program, dan kontak berada di sini
| agar mudah diperbarui tanpa menyentuh Blade. Bagian yang belum memiliki
| data resmi sengaja dibiarkan kosong dan akan tampil sebagai empty state
| di halaman publik.
|
| Tipe section yang didukung (lihat resources/views/public/pages/sections):
|   prose, cards, list, steps, documents, departments
|
*/

return [

    /* ------------------------------------------------------------------
     | Tentang FPUI
     * ------------------------------------------------------------------ */

    'ad_art' => [
        'sections' => [
            [
                'type' => 'prose',
                'title' => 'Anggaran Dasar dan Anggaran Rumah Tangga',
                'body' => '<p>Anggaran Dasar (AD) dan Anggaran Rumah Tangga (ART) merupakan landasan hukum yang mengatur tujuan, struktur, kewenangan, dan tata kerja Forum Perpustakaan Umum Indonesia. Kedua dokumen ini menjadi rujukan seluruh pengurus dan anggota dalam menjalankan kegiatan organisasi.</p>'
                    . '<p>Dokumen final periode 2025–2028 akan diunggah pada bagian di bawah setelah proses penetapan selesai. Untuk memperoleh salinan resmi lebih awal, silakan menghubungi Sekretariat FPUI.</p>',
            ],
            [
                'type' => 'documents',
                'title' => 'Dokumen AD/ART',
                'items' => [
                    [
                        'title' => 'Anggaran Dasar FPUI 2025–2028',
                        'meta' => 'PDF',
                        'description' => 'Dokumen anggaran dasar hasil Musyawarah Nasional FPUI.',
                        'url' => null,
                    ],
                    [
                        'title' => 'Anggaran Rumah Tangga FPUI 2025–2028',
                        'meta' => 'PDF',
                        'description' => 'Ketentuan operasional organisasi sebagai penjabaran anggaran dasar.',
                        'url' => null,
                    ],
                ],
            ],
        ],
    ],

    'pengurus' => [
        'note' => 'Susunan pengurus periode 2025–2028 sedang dalam proses pemutakhiran data. Nama dan jabatan akan ditampilkan pada halaman ini setelah ditetapkan secara resmi.',
        'groups' => [
            ['title' => 'Dewan Pembina', 'members' => []],
            ['title' => 'Dewan Pengawas', 'members' => []],
            ['title' => 'Pengurus Inti', 'members' => []],
            ['title' => 'Departemen', 'members' => []],
        ],
    ],

    /* ------------------------------------------------------------------
     | Organisasi
     * ------------------------------------------------------------------ */

    'departemen' => [
        'sections' => [
            [
                'type' => 'prose',
                'title' => 'Enam Departemen FPUI',
                'body' => '<p>Dalam menjalankan program kerja, FPUI membagi tugas ke dalam enam departemen. Setiap departemen dipimpin oleh seorang kepala departemen dan bekerja secara sinergis dengan pengurus inti serta koordinator wilayah.</p>',
            ],
            [
                'type' => 'departments',
                'title' => 'Bidang Kerja',
            ],
        ],
    ],

    'departemen_items' => [

        'organisasi-dan-keanggotaan' => [
            'number' => '01',
            'title' => 'Organisasi dan Keanggotaan',
            'summary' => 'Penguatan tata kelola dan struktur kepengurusan FPUI, serta pengelolaan keanggotaan yang tertib dan transparan bagi seluruh perpustakaan umum di Indonesia.',
            'duties' => [
                'Menata administrasi organisasi, termasuk kepengurusan, sekretariat, dan koordinator wilayah.',
                'Mengelola pendataan anggota, pembaruan data, serta penerbitan kartu anggota.',
                'Menyusun instrumen dan jadwal evaluasi kinerja organisasi.',
                'Memfasilitasi musyawarah, rapat kerja, dan forum komunikasi pengurus.',
            ],
        ],

        'publikasi-dan-dokumentasi' => [
            'number' => '02',
            'title' => 'Publikasi dan Dokumentasi',
            'summary' => 'Penyiapan publikasi dan dokumentasi kegiatan FPUI dalam format cetak maupun digital sebagai sumber rujukan dan jejak aktivitas organisasi.',
            'duties' => [
                'Mengelola kanal publikasi resmi: berita, artikel, buletin, dan media sosial.',
                'Mendokumentasikan kegiatan dalam bentuk foto, video, dan laporan tertulis.',
                'Menyusun buletin dan laporan tahunan organisasi.',
                'Menjaga konsistensi identitas visual dan pesan publikasi FPUI.',
            ],
        ],

        'kerja-sama-antar-lembaga' => [
            'number' => '03',
            'title' => 'Kerja Sama Antar Lembaga',
            'summary' => 'Membangun jejaring kolaborasi dengan pemerintah daerah, perguruan tinggi, lembaga profesi, dan komunitas literasi untuk bersama memperkuat kapasitas perpustakaan umum.',
            'duties' => [
                'Menyusun peta mitra dan peluang kolaborasi tingkat nasional maupun daerah.',
                'Menyiapkan draf naskah kerja sama dan mendampingi proses penandatanganan.',
                'Memantau pelaksanaan perjanjian kerja sama agar berjalan sesuai kesepakatan.',
                'Menjadi penghubung FPUI dengan asosiasi dan lembaga profesi.',
            ],
        ],

        'usaha-dana' => [
            'number' => '04',
            'title' => 'Usaha Dana',
            'summary' => 'Upaya penguatan sumber daya melalui skema usaha yang berkelanjutan, sponsorship, kemitraan, serta pengelolaan dana yang transparan bagi program FPUI.',
            'duties' => [
                'Menyusun rencana penggalangan dana dan skema sponsorship kegiatan.',
                'Mengelola unit usaha dan kemitraan komersial yang tidak bertentangan dengan nilai organisasi.',
                'Menyusun laporan keuangan kegiatan secara berkala dan terbuka.',
                'Mengidentifikasi sumber pendanaan hibah dan program pemerintah.',
            ],
        ],

        'pendidikan-dan-pelatihan' => [
            'number' => '05',
            'title' => 'Pendidikan dan Pelatihan',
            'summary' => 'Menyelenggarakan pendidikan, pelatihan, dan transfer pengetahuan bagi pengelola perpustakaan umum agar memiliki kompetensi yang sesuai tuntutan zaman.',
            'duties' => [
                'Menyusun kurikulum dan modul pelatihan pengelola perpustakaan umum.',
                'Menyelenggarakan seminar, webinar, dan lokakarya berskala nasional maupun daerah.',
                'Bekerja sama dengan perguruan tinggi dan lembaga pelatihan.',
                'Melakukan evaluasi pascapelatihan untuk mengukur dampak kegiatan.',
            ],
        ],

        'sertifikasi-dan-akreditasi' => [
            'number' => '06',
            'title' => 'Sertifikasi dan Akreditasi',
            'summary' => 'Mendukung peningkatan kompetensi dan pengakuan profesi pustakawan melalui skema sertifikasi serta pendampingan akreditasi perpustakaan.',
            'duties' => [
                'Menyosialisasikan skema sertifikasi kompetensi pustakawan.',
                'Mendampingi perpustakaan umum dalam proses akreditasi.',
                'Menyusun instrumen penilaian mutu layanan perpustakaan.',
                'Menghimpun data perpustakaan terakreditasi sebagai basis pembinaan.',
            ],
        ],

    ],

    'koordinator_wilayah' => [
        'sections' => [
            [
                'type' => 'prose',
                'title' => 'Peran Koordinator Wilayah',
                'body' => '<p>Koordinator wilayah merupakan perpanjangan tangan FPUI di tingkat provinsi dan kawasan. Mereka memfasilitasi komunikasi antar perpustakaan umum, menghimpun data daerah, serta mendukung pelaksanaan program nasional di wilayah masing-masing.</p>',
            ],
            [
                'type' => 'cards',
                'title' => 'Wilayah Koordinasi',
                'columns' => 3,
                'items' => [
                    ['title' => 'Sumatera', 'text' => 'Koordinasi perpustakaan umum di wilayah Sumatera.'],
                    ['title' => 'Jawa', 'text' => 'Koordinasi perpustakaan umum di wilayah Jawa.'],
                    ['title' => 'Kalimantan', 'text' => 'Koordinasi perpustakaan umum di wilayah Kalimantan.'],
                    ['title' => 'Sulawesi', 'text' => 'Koordinasi perpustakaan umum di wilayah Sulawesi.'],
                    ['title' => 'Bali dan Nusa Tenggara', 'text' => 'Koordinasi perpustakaan umum di Bali dan Nusa Tenggara.'],
                    ['title' => 'Maluku dan Papua', 'text' => 'Koordinasi perpustakaan umum di Maluku dan Papua.'],
                ],
            ],
            [
                'type' => 'prose',
                'title' => 'Data Koordinator',
                'body' => '<p>Nama dan kontak koordinator wilayah akan ditampilkan setelah penetapan pengurus periode 2025–2028. Untuk kebutuhan koordinasi mendesak, silakan menghubungi Sekretariat FPUI.</p>',
            ],
        ],
    ],

    'keanggotaan' => [
        'sections' => [
            [
                'type' => 'prose',
                'title' => 'Menjadi Anggota FPUI',
                'body' => '<p>Keanggotaan FPUI terbuka bagi perpustakaan umum, lembaga, dan perorangan yang memiliki kepedulian terhadap pengembangan layanan perpustakaan dan literasi masyarakat. Melalui keanggotaan, Anda terhubung dengan jejaring pengelola perpustakaan dari seluruh Indonesia.</p>',
            ],
            [
                'type' => 'cards',
                'title' => 'Manfaat Keanggotaan',
                'columns' => 3,
                'items' => [
                    ['title' => 'Jejaring Nasional', 'text' => 'Terhubung dengan pengelola perpustakaan umum dari berbagai daerah.'],
                    ['title' => 'Pelatihan', 'text' => 'Prioritas mengikuti seminar, webinar, dan pelatihan yang diselenggarakan FPUI.'],
                    ['title' => 'Pendampingan', 'text' => 'Dukungan teknis dan pendampingan pengembangan layanan perpustakaan.'],
                    ['title' => 'Publikasi', 'text' => 'Kesempatan berbagi praktik baik melalui kanal publikasi FPUI.'],
                    ['title' => 'Informasi Kebijakan', 'text' => 'Akses informasi regulasi dan program pemerintah di bidang perpustakaan.'],
                    ['title' => 'Kolaborasi', 'text' => 'Peluang kerja sama antarlembaga dan antardaerah.'],
                ],
            ],
            [
                'type' => 'steps',
                'title' => 'Alur Pendaftaran',
                'items' => [
                    ['title' => 'Unduh dan isi formulir', 'text' => 'Formulir pendaftaran anggota dapat diminta melalui Sekretariat FPUI.'],
                    ['title' => 'Lengkapi berkas', 'text' => 'Lampirkan profil singkat lembaga atau data perorangan yang diperlukan.'],
                    ['title' => 'Verifikasi', 'text' => 'Pengurus memverifikasi kelengkapan data dan status keanggotaan.'],
                    ['title' => 'Pengumuman', 'text' => 'Status keanggotaan disampaikan melalui email resmi FPUI.'],
                ],
            ],
            [
                'type' => 'prose',
                'title' => 'Informasi Pendaftaran',
                'body' => '<p>Untuk memperoleh formulir dan informasi iuran anggota, silakan menghubungi Sekretariat FPUI melalui halaman <a class="text-emerald-700 underline" href="/kontak/hubungi-kami">Hubungi Kami</a>.</p>',
            ],
        ],
    ],

    /* ------------------------------------------------------------------
     | Program & Kegiatan
     * ------------------------------------------------------------------ */

    'program_kerja' => [
        'intro' => 'Enam program strategis yang menjadi kerangka kerja FPUI dalam periode 2025–2028 untuk memperkuat peran perpustakaan umum di seluruh Indonesia.',
        'items' => [
            [
                'number' => '01',
                'title' => 'Organisasi dan Keanggotaan',
                'description' => 'Penguatan tata kelola dan struktur kepengurusan FPUI, serta pengelolaan keanggotaan yang tertib dan transparan bagi seluruh perpustakaan umum di Indonesia.',
            ],
            [
                'number' => '02',
                'title' => 'Publikasi dan Dokumentasi',
                'description' => 'Penyiapan publikasi dan dokumentasi kegiatan FPUI dalam format cetak maupun digital sebagai sumber rujukan dan jejak aktivitas organisasi.',
            ],
            [
                'number' => '03',
                'title' => 'Kerja Sama Antar Lembaga',
                'description' => 'Membangun jejaring kolaborasi dengan pemerintah daerah, perguruan tinggi, lembaga profesi, dan komunitas literasi untuk bersama memperkuat kapasitas perpustakaan umum.',
            ],
            [
                'number' => '04',
                'title' => 'Usaha dan Dana',
                'description' => 'Upaya penguatan sumber daya melalui skema usaha yang berkelanjutan, sponsorship, kemitraan, serta pengelolaan dana yang transparan bagi program FPUI.',
            ],
            [
                'number' => '05',
                'title' => 'Pendidikan dan Pelatihan',
                'description' => 'Menyelenggarakan pendidikan, pelatihan, dan transfer pengetahuan bagi pengelola perpustakaan umum agar memiliki kompetensi yang sesuai tuntutan zaman.',
            ],
            [
                'number' => '06',
                'title' => 'Sertifikasi dan Akreditasi',
                'description' => 'Mendukung peningkatan kompetensi dan pengakuan profesi pustakawan melalui skema sertifikasi serta pendampingan akreditasi perpustakaan.',
            ],
        ],
    ],

    'agenda' => [
        'sections' => [
            [
                'type' => 'prose',
                'title' => 'Agenda Kegiatan',
                'body' => '<p>Halaman ini memuat jadwal kegiatan FPUI yang akan datang, meliputi rapat kerja, seminar, webinar, pelatihan, dan pertemuan jejaring. Agenda diperbarui secara berkala oleh Sekretariat.</p>',
            ],
            [
                'type' => 'list',
                'title' => 'Agenda Terjadwal',
                'empty' => 'Belum ada agenda yang dijadwalkan. Silakan periksa kembali beberapa waktu ke depan.',
                'items' => [],
            ],
        ],
    ],

    'kegiatan' => [
        'sections' => [
            [
                'type' => 'prose',
                'title' => 'Dokumentasi Kegiatan',
                'body' => '<p>FPUI secara rutin menyelenggarakan kegiatan bersama jejaring perpustakaan umum, mulai dari seminar nasional, pelatihan pengelola perpustakaan, hingga pendampingan akreditasi. Dokumentasi lengkap dipublikasikan melalui kanal berita dan galeri foto.</p>',
            ],
            [
                'type' => 'list',
                'title' => 'Kegiatan Terlaksana',
                'empty' => 'Dokumentasi kegiatan akan ditampilkan di sini.',
                'items' => [],
            ],
            [
                'type' => 'prose',
                'title' => 'Ikuti Kegiatan Berikutnya',
                'body' => '<p>Informasi kegiatan terbaru dapat dilihat pada halaman <a class="text-emerald-700 underline" href="/publikasi/berita">Berita</a> dan <a class="text-emerald-700 underline" href="/program/agenda">Agenda</a>.</p>',
            ],
        ],
    ],

    'pendidikan_pelatihan' => [
        'sections' => [
            [
                'type' => 'prose',
                'title' => 'Peningkatan Kompetensi',
                'body' => '<p>Program pendidikan dan pelatihan FPUI dirancang untuk memperkuat kompetensi teknis maupun manajerial pengelola perpustakaan umum. Materi disusun bersama praktisi, akademisi, dan pengurus departemen terkait.</p>',
            ],
            [
                'type' => 'cards',
                'title' => 'Bentuk Kegiatan',
                'columns' => 3,
                'items' => [
                    ['title' => 'Pelatihan Daring', 'text' => 'Webinar dan kelas daring dengan materi aplikatif bagi pengelola perpustakaan.'],
                    ['title' => 'Pelatihan Tatap Muka', 'text' => 'Workshop intensif dengan praktik langsung dan pendampingan fasilitator.'],
                    ['title' => 'Tempat Belajar Bersama', 'text' => 'Forum berbagi pengalaman antarperpustakaan umum dari berbagai daerah.'],
                ],
            ],
            [
                'type' => 'prose',
                'title' => 'Materi dan Modul',
                'body' => '<p>Materi pelatihan yang telah dilaksanakan dapat diakses pada menu <a class="text-emerald-700 underline" href="/informasi/materi">Materi Seminar/Webinar</a> dan <a class="text-emerald-700 underline" href="/informasi/modul">Modul</a>.</p>',
            ],
        ],
    ],

    'sertifikasi_akreditasi' => [
        'sections' => [
            [
                'type' => 'prose',
                'title' => 'Sertifikasi Kompetensi',
                'body' => '<p>FPUI mendukung pengakuan kompetensi pustakawan melalui sosialisasi skema sertifikasi profesi dan penyiapan calon peserta. Program ini dilaksanakan bersama lembaga sertifikasi dan perguruan tinggi mitra.</p>',
            ],
            [
                'type' => 'prose',
                'title' => 'Akreditasi Perpustakaan',
                'body' => '<p>Pendampingan akreditasi ditujukan bagi perpustakaan umum yang akan mengikuti penilaian mutu. Pendampingan mencakup penyiapan dokumen, evaluasi layanan, dan simulasi penilaian.</p>',
            ],
            [
                'type' => 'steps',
                'title' => 'Tahapan Pendampingan',
                'items' => [
                    ['title' => 'Pendaftaran', 'text' => 'Perpustakaan mendaftar melalui Sekretariat FPUI.'],
                    ['title' => 'Asesmen Awal', 'text' => 'Tim melakukan penilaian awal terhadap kesiapan dokumen dan layanan.'],
                    ['title' => 'Pendampingan', 'text' => 'Pendampingan perbaikan dokumen dan peningkatan layanan.'],
                    ['title' => 'Evaluasi', 'text' => 'Evaluasi akhir sebelum proses akreditasi resmi dilaksanakan.'],
                ],
            ],
        ],
    ],

    'kerja_sama_program' => [
        'sections' => [
            [
                'type' => 'prose',
                'title' => 'Kolaborasi Lintas Lembaga',
                'body' => '<p>Kerja sama merupakan salah satu pilar program FPUI. Kolaborasi dilakukan dengan pemerintah pusat dan daerah, perguruan tinggi, asosiasi profesi, penerbit, serta komunitas literasi. Setiap kerja sama diarahkan pada penguatan layanan perpustakaan umum dan perluasan akses masyarakat terhadap pengetahuan.</p>',
            ],
            [
                'type' => 'cards',
                'title' => 'Bentuk Kerja Sama',
                'columns' => 3,
                'items' => [
                    ['title' => 'Pemerintah Daerah', 'text' => 'Penguatan kebijakan dan pembinaan perpustakaan umum di daerah.'],
                    ['title' => 'Perguruan Tinggi', 'text' => 'Kolaborasi riset, pelatihan, dan pengembangan kompetensi pustakawan.'],
                    ['title' => 'Lembaga Profesi', 'text' => 'Sertifikasi, kode etik, dan pengembangan profesi pustakawan.'],
                    ['title' => 'Komunitas Literasi', 'text' => 'Program literasi masyarakat berbasis komunitas.'],
                    ['title' => 'Sektor Swasta', 'text' => 'Dukungan sumber daya, teknologi, dan program tanggung jawab sosial.'],
                    ['title' => 'Lembaga Internasional', 'text' => 'Pertukaran pengetahuan dan program pengembangan kapasitas.'],
                ],
            ],
            [
                'type' => 'prose',
                'title' => 'Ajukan Kerja Sama',
                'body' => '<p>Usulan kerja sama dapat disampaikan melalui halaman <a class="text-emerald-700 underline" href="/kontak/kerja-sama">Kerja Sama</a> atau langsung kepada Sekretariat FPUI.</p>',
            ],
        ],
    ],

    /* ------------------------------------------------------------------
     | Kontak
     * ------------------------------------------------------------------ */

    'sekretariat' => [
        'mode' => 'sekretariat',
        'hours' => 'Senin – Jumat, 08.00 – 16.00 WIB',
        'note' => 'Kunjungan dimohon membuat janji terlebih dahulu melalui email atau telepon.',
    ],

    'hubungi_kami' => [
        'mode' => 'hubungi-kami',
        'hours' => 'Senin – Jumat, 08.00 – 16.00 WIB',
        'channels' => [
            [
                'title' => 'Pertanyaan Umum',
                'text' => 'Informasi mengenai organisasi, program, dan kegiatan FPUI.',
            ],
            [
                'title' => 'Keanggotaan',
                'text' => 'Pendaftaran anggota, pembaruan data, dan iuran keanggotaan.',
            ],
            [
                'title' => 'Media dan Publikasi',
                'text' => 'Permohonan wawancara, publikasi, dan penggunaan materi FPUI.',
            ],
            [
                'title' => 'Kerja Sama',
                'text' => 'Usulan kemitraan dan kolaborasi antarlembaga.',
            ],
        ],
    ],

    'media_sosial' => [
        'mode' => 'media-sosial',
        'note' => 'Kanal resmi FPUI dikelola oleh Departemen Publikasi dan Dokumentasi.',
    ],

    'kontak_kerja_sama' => [
        'sections' => [
            [
                'type' => 'prose',
                'title' => 'Berkolaborasi dengan FPUI',
                'body' => '<p>FPUI membuka ruang kolaborasi bagi lembaga pemerintah, perguruan tinggi, asosiasi profesi, penerbit, komunitas literasi, maupun sektor swasta yang memiliki misi sejalan dengan penguatan perpustakaan umum dan literasi masyarakat.</p>',
            ],
            [
                'type' => 'cards',
                'title' => 'Skema Kolaborasi',
                'columns' => 2,
                'items' => [
                    ['title' => 'Kerja Sama Program', 'text' => 'Penyelenggaraan bersama seminar, pelatihan, dan program literasi.'],
                    ['title' => 'Dukungan Sumber Daya', 'text' => 'Dukungan koleksi, teknologi, fasilitas, atau pendanaan kegiatan.'],
                    ['title' => 'Pertukaran Pengetahuan', 'text' => 'Riset bersama, publikasi, dan pengembangan kapasitas.'],
                    ['title' => 'Jejaring Kelembagaan', 'text' => 'Keterlibatan dalam forum dan agenda nasional FPUI.'],
                ],
            ],
            [
                'type' => 'steps',
                'title' => 'Proses Pengajuan',
                'items' => [
                    ['title' => 'Kirim proposal', 'text' => 'Sampaikan profil lembaga dan rencana kolaborasi melalui email sekretariat.'],
                    ['title' => 'Penelaahan', 'text' => 'Departemen Kerja Sama Antar Lembaga menelaah kesesuaian program.'],
                    ['title' => 'Penyusunan kesepakatan', 'text' => 'Penyusunan draf naskah kerja sama bersama kedua pihak.'],
                    ['title' => 'Pelaksanaan', 'text' => 'Pelaksanaan kegiatan dan pelaporan hasil kerja sama.'],
                ],
            ],
        ],
    ],

];
