<?php

return [

    [
        'label' => 'Dashboard',
        'route' => 'admin.dashboard',
        'active_pattern' => 'admin.dashboard',
        'roles' => ['admin', 'user'],
    ],

    [
        'label' => 'Publikasi',
        'roles' => ['admin', 'user'],
        'children' => [
            [
                'label' => 'Berita',
                'route' => 'admin.news.index',
                'active_pattern' => 'admin.news.*',
                'roles' => ['admin', 'user'],
            ],
            [
                'label' => 'Artikel',
                'route' => 'admin.article.index',
                'active_pattern' => 'admin.article.*',
                'roles' => ['admin', 'user'],
            ],
            [
                'label' => 'FPUI Praktik Terbaik',
                'route' => 'admin.best-practice.index',
                'active_pattern' => 'admin.best-practice.*',
                'roles' => ['admin', 'user'],
            ],
            [
                'label' => 'Buletin',
                'route' => 'admin.bulletin.index',
                'active_pattern' => 'admin.bulletin.*',
                'roles' => ['admin', 'user'],
            ],
            [
                'label' => 'Infografis',
                'route' => 'admin.infographic.index',
                'active_pattern' => 'admin.infographic.*',
                'roles' => ['admin', 'user'],
            ],
            [
                'label' => 'Video',
                'route' => 'admin.video.index',
                'active_pattern' => 'admin.video.*',
                'roles' => ['admin', 'user'],
            ],
            [
                'label' => 'Galeri Foto',
                'route' => 'admin.photo.index',
                'active_pattern' => 'admin.photo.*',
                'roles' => ['admin'],
            ],
        ],
    ],

    [
        'label' => 'Banner',
        'route' => 'admin.banner.index',
        'active_pattern' => 'admin.banner.index',
        'roles' => ['admin'],
    ],

    [
        'label' => 'Dokumen',
        'route' => 'admin.document.index',
        'active_pattern' => 'admin.document.*',
        'roles' => ['admin'],
    ],

    [
        'label' => 'Pengaturan',
        'roles' => ['admin'],
        'children' => [
            [
                'label' => 'Profil Organisasi',
                'route' => 'admin.settings.organization.index',
                'active_pattern' => 'admin.settings.organization.*',
                'roles' => ['admin'],
            ],
            [
                'label' => 'Manajemen Kategori',
                'route' => 'admin.settings.category.index',
                'active_pattern' => 'admin.settings.category.*',
                'roles' => ['admin'],
            ],
            [
                'label' => 'Manajemen Pengguna',
                'route' => 'admin.settings.user.index',
                'active_pattern' => 'admin.settings.user.*',
                'roles' => ['admin'],
            ],
            [
                'label' => 'Instagram Feed',
                'route' => 'admin.settings.instagram.index',
                'active_pattern' => 'admin.settings.instagram.*',
                'roles' => ['admin'],
            ],
        ],
    ],

];
