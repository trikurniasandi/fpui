<?php

/*
|--------------------------------------------------------------------------
| Registry Jenis Dokumen (menu Informasi)
|--------------------------------------------------------------------------
|
| Setiap jenis memakai tabel `documents` yang sama dengan kolom `type`
| sebagai pembeda. Path dan nama route dipakai untuk halaman publik.
|
*/

return [

    'regulasi' => [
        'label' => 'Regulasi',
        'path' => 'informasi/regulasi',
        'route_name' => 'informasi.regulasi',
        'intro' => 'Kumpulan peraturan, kebijakan, dan regulasi yang menjadi rujukan pengelolaan perpustakaan umum serta tata kelola FPUI.',
    ],

    'pedoman' => [
        'label' => 'Pedoman dan Panduan',
        'path' => 'informasi/pedoman-panduan',
        'route_name' => 'informasi.pedoman-panduan',
        'intro' => 'Pedoman kerja, panduan teknis, dan standar operasional yang disusun FPUI untuk mendukung pengelolaan perpustakaan umum.',
    ],

    'modul' => [
        'label' => 'Modul',
        'path' => 'informasi/modul',
        'route_name' => 'informasi.modul',
        'intro' => 'Modul pembelajaran dan bahan ajar yang dapat digunakan pengelola perpustakaan dalam kegiatan pembinaan dan pelatihan.',
    ],

    'materi' => [
        'label' => 'Materi Seminar/Webinar',
        'path' => 'informasi/materi',
        'route_name' => 'informasi.materi',
        'intro' => 'Materi presentasi seminar, webinar, dan lokakarya yang diselenggarakan FPUI.',
    ],

    'hasil_kajian' => [
        'label' => 'Hasil Kajian',
        'path' => 'informasi/hasil-kajian',
        'route_name' => 'informasi.hasil-kajian',
        'intro' => 'Laporan kajian dan studi yang dihasilkan FPUI sebagai dasar pengembangan program dan kebijakan perpustakaan umum.',
    ],

    'repository' => [
        'label' => 'Repository',
        'path' => 'informasi/repository',
        'route_name' => 'informasi.repository',
        'intro' => 'Kumpulan dokumen, publikasi, dan arsip digital FPUI yang dapat diakses publik.',
    ],

];
