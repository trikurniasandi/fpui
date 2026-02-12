<?php

return [

    [
        'label' => 'Dashboard',
        'route' => 'admin.dashboard',
        'active_pattern' => 'admin.dashboard',
    ],

    [
        'label' => 'Artikel',
        'route' => 'admin.article.index',
        'active_pattern' => 'admin.article.*',
    ],

    [
        'label' => 'Berita',
        'route' => 'admin.news.index',
        'active_pattern' => 'admin.news.*',
    ],

    [
        'label' => 'Pengaturan',
        'children' => [
            [
                'label' => 'Profil Organisasi',
                'route' => 'admin.settings.organization.index',
                'active_pattern' => 'admin.settings.organization.*',
            ],
            [
                'label' => 'Master Kategori',
                'route' => 'admin.settings.category.index',
                'active_pattern' => 'admin.settings.category.*',
            ],
        ],
    ],

];
