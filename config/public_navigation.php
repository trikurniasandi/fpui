<?php

/*
|--------------------------------------------------------------------------
| Navigasi Publik (maks. 3 level)
|--------------------------------------------------------------------------
|
| Struktur tiap item:
|   label          => teks menu
|   route          => nama route (wajib bila tidak punya children)
|   params         => parameter route (opsional)
|   active_pattern => pola routeIs() untuk menandai menu aktif
|   children       => array item dengan struktur yang sama (opsional)
|
*/

return [

    [
        'label' => 'Beranda',
        'route' => 'home',
        'active_pattern' => 'home',
    ],

    [
        'label' => 'Tentang FPUI',
        'active_pattern' => 'tentang.*',
        'children' => [
            [
                'label' => 'Profil',
                'route' => 'tentang.profil',
                'active_pattern' => 'tentang.profil',
            ],
            [
                'label' => 'Sejarah',
                'route' => 'tentang.sejarah',
                'active_pattern' => 'tentang.sejarah',
            ],
            [
                'label' => 'Visi dan Misi',
                'route' => 'tentang.visi-misi',
                'active_pattern' => 'tentang.visi-misi',
            ],
            [
                'label' => 'AD/ART',
                'route' => 'tentang.ad-art',
                'active_pattern' => 'tentang.ad-art',
            ],
            [
                'label' => 'Struktur Organisasi',
                'route' => 'tentang.struktur-organisasi',
                'active_pattern' => 'tentang.struktur-organisasi',
            ],
            [
                'label' => 'Pengurus 2025–2028',
                'route' => 'tentang.pengurus',
                'active_pattern' => 'tentang.pengurus',
            ],
        ],
    ],

    [
        'label' => 'Organisasi',
        'active_pattern' => 'organisasi.*',
        'children' => [
            [
                'label' => 'Departemen',
                'active_pattern' => 'organisasi.departemen*',
                'children' => [
                    [
                        'label' => 'Organisasi dan Keanggotaan',
                        'route' => 'organisasi.departemen.show',
                        'params' => ['departemen' => 'organisasi-dan-keanggotaan'],
                        'active_pattern' => 'organisasi.departemen.show',
                    ],
                    [
                        'label' => 'Publikasi dan Dokumentasi',
                        'route' => 'organisasi.departemen.show',
                        'params' => ['departemen' => 'publikasi-dan-dokumentasi'],
                        'active_pattern' => 'organisasi.departemen.show',
                    ],
                    [
                        'label' => 'Kerja Sama Antar Lembaga',
                        'route' => 'organisasi.departemen.show',
                        'params' => ['departemen' => 'kerja-sama-antar-lembaga'],
                        'active_pattern' => 'organisasi.departemen.show',
                    ],
                    [
                        'label' => 'Usaha Dana',
                        'route' => 'organisasi.departemen.show',
                        'params' => ['departemen' => 'usaha-dana'],
                        'active_pattern' => 'organisasi.departemen.show',
                    ],
                    [
                        'label' => 'Pendidikan dan Pelatihan',
                        'route' => 'organisasi.departemen.show',
                        'params' => ['departemen' => 'pendidikan-dan-pelatihan'],
                        'active_pattern' => 'organisasi.departemen.show',
                    ],
                    [
                        'label' => 'Sertifikasi dan Akreditasi',
                        'route' => 'organisasi.departemen.show',
                        'params' => ['departemen' => 'sertifikasi-dan-akreditasi'],
                        'active_pattern' => 'organisasi.departemen.show',
                    ],
                ],
            ],
            [
                'label' => 'Koordinator Wilayah',
                'route' => 'organisasi.koordinator-wilayah',
                'active_pattern' => 'organisasi.koordinator-wilayah',
            ],
            [
                'label' => 'Keanggotaan',
                'route' => 'organisasi.keanggotaan',
                'active_pattern' => 'organisasi.keanggotaan',
            ],
        ],
    ],

    [
        'label' => 'Program & Kegiatan',
        'active_pattern' => 'program.*',
        'children' => [
            [
                'label' => 'Program Kerja 2025–2028',
                'route' => 'program.program-kerja',
                'active_pattern' => 'program.program-kerja',
            ],
            [
                'label' => 'Agenda',
                'route' => 'program.agenda',
                'active_pattern' => 'program.agenda',
            ],
            [
                'label' => 'Kegiatan',
                'route' => 'program.kegiatan',
                'active_pattern' => 'program.kegiatan',
            ],
            [
                'label' => 'Pendidikan dan Pelatihan',
                'route' => 'program.pendidikan-pelatihan',
                'active_pattern' => 'program.pendidikan-pelatihan',
            ],
            [
                'label' => 'Sertifikasi dan Akreditasi',
                'route' => 'program.sertifikasi-akreditasi',
                'active_pattern' => 'program.sertifikasi-akreditasi',
            ],
            [
                'label' => 'Kerja Sama',
                'route' => 'program.kerja-sama',
                'active_pattern' => 'program.kerja-sama',
            ],
        ],
    ],

    [
        'label' => 'Publikasi',
        'active_pattern' => [
            'article.*',
            'news.*',
            'best-practice.*',
            'bulletin.*',
            'infographic.*',
            'video.*',
            'photo.*',
        ],
        'children' => [
            [
                'label' => 'Berita',
                'route' => 'news.index',
                'active_pattern' => 'news.*',
            ],
            [
                'label' => 'Artikel',
                'route' => 'article.index',
                'active_pattern' => 'article.*',
            ],
            [
                'label' => 'FPUI Praktik Terbaik',
                'route' => 'best-practice.index',
                'active_pattern' => 'best-practice.*',
            ],
            [
                'label' => 'Buletin',
                'route' => 'bulletin.index',
                'active_pattern' => 'bulletin.*',
            ],
            [
                'label' => 'Infografis',
                'route' => 'infographic.index',
                'active_pattern' => 'infographic.*',
            ],
            [
                'label' => 'Galeri Foto',
                'route' => 'photo.index',
                'active_pattern' => 'photo.*',
            ],
            [
                'label' => 'Video',
                'route' => 'video.index',
                'active_pattern' => 'video.*',
            ],
        ],
    ],

    [
        'label' => 'Informasi',
        'active_pattern' => 'informasi.*',
        'children' => [
            [
                'label' => 'Regulasi',
                'route' => 'informasi.regulasi',
                'active_pattern' => 'informasi.regulasi',
            ],
            [
                'label' => 'Pedoman dan Panduan',
                'route' => 'informasi.pedoman-panduan',
                'active_pattern' => 'informasi.pedoman-panduan',
            ],
            [
                'label' => 'Modul',
                'route' => 'informasi.modul',
                'active_pattern' => 'informasi.modul',
            ],
            [
                'label' => 'Materi Seminar/Webinar',
                'route' => 'informasi.materi',
                'active_pattern' => 'informasi.materi',
            ],
            [
                'label' => 'Hasil Kajian',
                'route' => 'informasi.hasil-kajian',
                'active_pattern' => 'informasi.hasil-kajian',
            ],
            [
                'label' => 'Repository',
                'route' => 'informasi.repository',
                'active_pattern' => 'informasi.repository',
            ],
        ],
    ],

    [
        'label' => 'Kontak',
        'active_pattern' => 'kontak.*',
        'children' => [
            [
                'label' => 'Sekretariat FPUI',
                'route' => 'kontak.sekretariat',
                'active_pattern' => 'kontak.sekretariat',
            ],
            [
                'label' => 'Hubungi Kami',
                'route' => 'kontak.hubungi-kami',
                'active_pattern' => 'kontak.hubungi-kami',
            ],
            [
                'label' => 'Kerja Sama',
                'route' => 'kontak.kerja-sama',
                'active_pattern' => 'kontak.kerja-sama',
            ],
            [
                'label' => 'Media Sosial',
                'route' => 'kontak.media-sosial',
                'active_pattern' => 'kontak.media-sosial',
            ],
        ],
    ],

];
