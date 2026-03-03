<?php

return [

    [
        'label' => 'Dashboard',
        'route' => 'admin.dashboard',
        'active_pattern' => 'admin.dashboard',
        'roles' => ['admin', 'user'],
    ],

    [
        'label' => 'Banner',
        'route' => 'admin.banner.index',
        'active_pattern' => 'admin.banner.index',
        'roles' => ['admin'],
    ],

    [
        'label' => 'Artikel',
        'route' => 'admin.article.index',
        'active_pattern' => 'admin.article.*',
        'roles' => ['admin', 'user'],
    ],

    [
        'label' => 'Berita',
        'route' => 'admin.news.index',
        'active_pattern' => 'admin.news.*',
        'roles' => ['admin', 'user'],
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
        ],
    ],

];
