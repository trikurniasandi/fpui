<?php

return [

    [
        'label' => 'Beranda',
        'route' => 'home',
    ],

    [
        'label' => 'Profil',
        'active_pattern' => 'profile.*',
        'children' => [
            [
                'label' => 'Struktur Organisasi',
                'route' => 'profile.structure',
                'active_pattern' => 'profile.structure',
            ],
            [
                'label' => 'Sejarah FPUI ',
                'route' => 'profile.history',
                'active_pattern' => 'profile.history',
            ],
        ],
    ],

    [
        'label' => 'Artikel',
        'route' => 'article.index',
        'active_pattern' => 'article.*',
    ],

    [
        'label' => 'Berita',
        'route' => 'news.index',
        'active_pattern' => 'news.*',
    ],

    [
        'label' => 'Tentang',
        'route' => 'public.about',
    ],

];