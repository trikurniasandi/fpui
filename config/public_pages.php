<?php

/*
|--------------------------------------------------------------------------
| Halaman Statis Publik
|--------------------------------------------------------------------------
|
| Key array = nama route. Setiap halaman didaftarkan otomatis di
| routes/web.php melalui PageController.
|
|   path        => URL relatif tanpa slash awal
|   title       => <title> halaman
|   meta        => meta description
|   heading     => judul besar pada hero
|   subheading  => paragraf pembuka pada hero
|   eyebrow     => label kecil di atas judul (opsional)
|   breadcrumb  => item breadcrumb, item terakhir tanpa 'route'
|   view        => blade yang dipakai
|   content     => key pada config/public_content.php (opsional)
|
*/

return [

    'tentang.profil' => [
        'path' => 'tentang/profil',
        'title' => 'Profil FPUI',
        'meta' => 'Profil Forum Perpustakaan Umum Indonesia (FPUI) sebagai wadah kolaborasi perpustakaan umum di seluruh Indonesia.',
        'heading' => 'Profil FPUI',
        'subheading' => 'Mengenal lebih dekat Forum Perpustakaan Umum Indonesia: latar belakang, peran, dan komitmen kami.',
        'eyebrow' => 'Tentang FPUI',
        'breadcrumb' => [
            ['label' => 'Tentang FPUI'],
            ['label' => 'Profil'],
        ],
        'view' => 'public.pages.profil',
    ],

    'tentang.sejarah' => [
        'path' => 'tentang/sejarah',
        'title' => 'Sejarah FPUI',
        'meta' => 'Sejarah berdirinya Forum Perpustakaan Umum Indonesia (FPUI).',
        'heading' => 'Sejarah FPUI',
        'subheading' => 'Perjalanan Forum Perpustakaan Umum Indonesia dalam membangun kolaborasi, memperkuat literasi, dan mengembangkan perpustakaan umum di seluruh Indonesia.',
        'eyebrow' => 'Tentang FPUI',
        'breadcrumb' => [
            ['label' => 'Tentang FPUI'],
            ['label' => 'Sejarah'],
        ],
        'view' => 'public.pages.sejarah',
    ],

    'tentang.visi-misi' => [
        'path' => 'tentang/visi-misi',
        'title' => 'Visi dan Misi FPUI',
        'meta' => 'Visi dan misi Forum Perpustakaan Umum Indonesia (FPUI).',
        'heading' => 'Visi dan Misi',
        'subheading' => 'Arah dan komitmen Forum Perpustakaan Umum Indonesia dalam memperkuat peran perpustakaan umum bagi masyarakat.',
        'eyebrow' => 'Tentang FPUI',
        'breadcrumb' => [
            ['label' => 'Tentang FPUI'],
            ['label' => 'Visi dan Misi'],
        ],
        'view' => 'public.pages.visi-misi',
    ],

    'tentang.ad-art' => [
        'path' => 'tentang/ad-art',
        'title' => 'AD/ART FPUI',
        'meta' => 'Anggaran Dasar dan Anggaran Rumah Tangga Forum Perpustakaan Umum Indonesia (FPUI).',
        'heading' => 'AD/ART',
        'subheading' => 'Anggaran Dasar dan Anggaran Rumah Tangga sebagai landasan hukum dan tata kelola organisasi FPUI.',
        'eyebrow' => 'Tentang FPUI',
        'breadcrumb' => [
            ['label' => 'Tentang FPUI'],
            ['label' => 'AD/ART'],
        ],
        'view' => 'public.pages.generic',
        'content' => 'ad_art',
    ],

    'tentang.struktur-organisasi' => [
        'path' => 'tentang/struktur-organisasi',
        'title' => 'Struktur Organisasi FPUI',
        'meta' => 'Struktur organisasi Forum Perpustakaan Umum Indonesia (FPUI).',
        'heading' => 'Struktur Organisasi',
        'subheading' => 'Susunan kepengurusan Forum Perpustakaan Umum Indonesia (FPUI) dalam menjalankan visi, misi, dan program organisasi secara profesional dan kolaboratif.',
        'eyebrow' => 'Tentang FPUI',
        'breadcrumb' => [
            ['label' => 'Tentang FPUI'],
            ['label' => 'Struktur Organisasi'],
        ],
        'view' => 'public.pages.struktur',
    ],

    'tentang.pengurus' => [
        'path' => 'tentang/pengurus-2025-2028',
        'title' => 'Pengurus FPUI 2025–2028',
        'meta' => 'Susunan pengurus Forum Perpustakaan Umum Indonesia periode 2025–2028.',
        'heading' => 'Pengurus 2025–2028',
        'subheading' => 'Susunan pengurus Forum Perpustakaan Umum Indonesia periode 2025–2028.',
        'eyebrow' => 'Tentang FPUI',
        'breadcrumb' => [
            ['label' => 'Tentang FPUI'],
            ['label' => 'Pengurus 2025–2028'],
        ],
        'view' => 'public.pages.pengurus',
        'content' => 'pengurus',
    ],

    'organisasi.departemen' => [
        'path' => 'organisasi/departemen',
        'title' => 'Departemen FPUI',
        'meta' => 'Enam departemen Forum Perpustakaan Umum Indonesia beserta bidang kerjanya.',
        'heading' => 'Departemen',
        'subheading' => 'Enam departemen yang menjalankan program kerja FPUI sesuai bidang masing-masing.',
        'eyebrow' => 'Organisasi',
        'breadcrumb' => [
            ['label' => 'Organisasi'],
            ['label' => 'Departemen'],
        ],
        'view' => 'public.pages.generic',
        'content' => 'departemen',
    ],

    'organisasi.koordinator-wilayah' => [
        'path' => 'organisasi/koordinator-wilayah',
        'title' => 'Koordinator Wilayah FPUI',
        'meta' => 'Koordinator wilayah Forum Perpustakaan Umum Indonesia sebagai penghubung daerah.',
        'heading' => 'Koordinator Wilayah',
        'subheading' => 'Jejaring koordinator wilayah yang menghubungkan FPUI dengan perpustakaan umum di seluruh Indonesia.',
        'eyebrow' => 'Organisasi',
        'breadcrumb' => [
            ['label' => 'Organisasi'],
            ['label' => 'Koordinator Wilayah'],
        ],
        'view' => 'public.pages.generic',
        'content' => 'koordinator_wilayah',
    ],

    'organisasi.keanggotaan' => [
        'path' => 'organisasi/keanggotaan',
        'title' => 'Keanggotaan FPUI',
        'meta' => 'Informasi keanggotaan Forum Perpustakaan Umum Indonesia: syarat, manfaat, dan alur pendaftaran.',
        'heading' => 'Keanggotaan',
        'subheading' => 'Menjadi bagian dari jejaring nasional pengelola perpustakaan umum di Indonesia.',
        'eyebrow' => 'Organisasi',
        'breadcrumb' => [
            ['label' => 'Organisasi'],
            ['label' => 'Keanggotaan'],
        ],
        'view' => 'public.pages.generic',
        'content' => 'keanggotaan',
    ],

    'program.program-kerja' => [
        'path' => 'program/program-kerja',
        'title' => 'Program Kerja FPUI 2025–2028',
        'meta' => 'Enam program strategis Forum Perpustakaan Umum Indonesia (FPUI) periode 2025–2028.',
        'heading' => 'Program Kerja 2025–2028',
        'subheading' => 'Enam program strategis yang menjadi kerangka kerja FPUI dalam periode 2025–2028 untuk memperkuat peran perpustakaan umum di seluruh Indonesia.',
        'eyebrow' => 'Periode 2025 – 2028',
        'breadcrumb' => [
            ['label' => 'Program & Kegiatan'],
            ['label' => 'Program Kerja 2025–2028'],
        ],
        'view' => 'public.pages.program-kerja',
        'content' => 'program_kerja',
    ],

    'program.agenda' => [
        'path' => 'program/agenda',
        'title' => 'Agenda FPUI',
        'meta' => 'Agenda kegiatan Forum Perpustakaan Umum Indonesia.',
        'heading' => 'Agenda',
        'subheading' => 'Jadwal kegiatan FPUI yang akan datang: seminar, pelatihan, rapat kerja, dan pertemuan jejaring.',
        'eyebrow' => 'Program & Kegiatan',
        'breadcrumb' => [
            ['label' => 'Program & Kegiatan'],
            ['label' => 'Agenda'],
        ],
        'view' => 'public.pages.generic',
        'content' => 'agenda',
    ],

    'program.kegiatan' => [
        'path' => 'program/kegiatan',
        'title' => 'Kegiatan FPUI',
        'meta' => 'Dokumentasi kegiatan Forum Perpustakaan Umum Indonesia.',
        'heading' => 'Kegiatan',
        'subheading' => 'Dokumentasi kegiatan yang telah dilaksanakan FPUI bersama jejaring perpustakaan umum.',
        'eyebrow' => 'Program & Kegiatan',
        'breadcrumb' => [
            ['label' => 'Program & Kegiatan'],
            ['label' => 'Kegiatan'],
        ],
        'view' => 'public.pages.generic',
        'content' => 'kegiatan',
    ],

    'program.pendidikan-pelatihan' => [
        'path' => 'program/pendidikan-pelatihan',
        'title' => 'Pendidikan dan Pelatihan FPUI',
        'meta' => 'Program pendidikan dan pelatihan Forum Perpustakaan Umum Indonesia.',
        'heading' => 'Pendidikan dan Pelatihan',
        'subheading' => 'Peningkatan kompetensi pengelola perpustakaan umum melalui pendidikan, pelatihan, dan transfer pengetahuan.',
        'eyebrow' => 'Program & Kegiatan',
        'breadcrumb' => [
            ['label' => 'Program & Kegiatan'],
            ['label' => 'Pendidikan dan Pelatihan'],
        ],
        'view' => 'public.pages.generic',
        'content' => 'pendidikan_pelatihan',
    ],

    'program.sertifikasi-akreditasi' => [
        'path' => 'program/sertifikasi-akreditasi',
        'title' => 'Sertifikasi dan Akreditasi FPUI',
        'meta' => 'Program sertifikasi dan akreditasi Forum Perpustakaan Umum Indonesia.',
        'heading' => 'Sertifikasi dan Akreditasi',
        'subheading' => 'Dukungan FPUI terhadap pengakuan kompetensi pustakawan serta peningkatan mutu perpustakaan umum.',
        'eyebrow' => 'Program & Kegiatan',
        'breadcrumb' => [
            ['label' => 'Program & Kegiatan'],
            ['label' => 'Sertifikasi dan Akreditasi'],
        ],
        'view' => 'public.pages.generic',
        'content' => 'sertifikasi_akreditasi',
    ],

    'program.kerja-sama' => [
        'path' => 'program/kerja-sama',
        'title' => 'Kerja Sama FPUI',
        'meta' => 'Program kerja sama Forum Perpustakaan Umum Indonesia dengan berbagai lembaga.',
        'heading' => 'Kerja Sama',
        'subheading' => 'Kolaborasi FPUI dengan pemerintah, perguruan tinggi, lembaga profesi, dan komunitas literasi.',
        'eyebrow' => 'Program & Kegiatan',
        'breadcrumb' => [
            ['label' => 'Program & Kegiatan'],
            ['label' => 'Kerja Sama'],
        ],
        'view' => 'public.pages.generic',
        'content' => 'kerja_sama_program',
    ],

    'kontak.sekretariat' => [
        'path' => 'kontak/sekretariat',
        'title' => 'Sekretariat FPUI',
        'meta' => 'Kontak Sekretariat Forum Perpustakaan Umum Indonesia.',
        'heading' => 'Sekretariat FPUI',
        'subheading' => 'Alamat, kontak, dan jam layanan Sekretariat FPUI.',
        'eyebrow' => 'Kontak',
        'breadcrumb' => [
            ['label' => 'Kontak'],
            ['label' => 'Sekretariat FPUI'],
        ],
        'view' => 'public.pages.kontak',
        'content' => 'sekretariat',
    ],

    'kontak.hubungi-kami' => [
        'path' => 'kontak/hubungi-kami',
        'title' => 'Hubungi Kami',
        'meta' => 'Hubungi Forum Perpustakaan Umum Indonesia melalui kanal resmi.',
        'heading' => 'Hubungi Kami',
        'subheading' => 'Sampaikan pertanyaan, masukan, atau permohonan informasi melalui kanal resmi FPUI.',
        'eyebrow' => 'Kontak',
        'breadcrumb' => [
            ['label' => 'Kontak'],
            ['label' => 'Hubungi Kami'],
        ],
        'view' => 'public.pages.kontak',
        'content' => 'hubungi_kami',
    ],

    'kontak.kerja-sama' => [
        'path' => 'kontak/kerja-sama',
        'title' => 'Kerja Sama dengan FPUI',
        'meta' => 'Informasi kerja sama dan kemitraan dengan Forum Perpustakaan Umum Indonesia.',
        'heading' => 'Kerja Sama',
        'subheading' => 'FPUI membuka peluang kolaborasi dengan lembaga, pemerintah daerah, perguruan tinggi, dan komunitas literasi.',
        'eyebrow' => 'Kontak',
        'breadcrumb' => [
            ['label' => 'Kontak'],
            ['label' => 'Kerja Sama'],
        ],
        'view' => 'public.pages.generic',
        'content' => 'kontak_kerja_sama',
    ],

    'kontak.media-sosial' => [
        'path' => 'kontak/media-sosial',
        'title' => 'Media Sosial FPUI',
        'meta' => 'Kanal media sosial resmi Forum Perpustakaan Umum Indonesia.',
        'heading' => 'Media Sosial',
        'subheading' => 'Ikuti kanal resmi FPUI untuk mendapatkan informasi terbaru.',
        'eyebrow' => 'Kontak',
        'breadcrumb' => [
            ['label' => 'Kontak'],
            ['label' => 'Media Sosial'],
        ],
        'view' => 'public.pages.kontak',
        'content' => 'media_sosial',
    ],

];
