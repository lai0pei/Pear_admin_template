<?php

return [
    'name' => '后台',
    'module' => 'backend',
    'title' => env('BACKEND_TITLE',''),
    'db_prefix' => env('DB_PREFIX',''),
    'guard' => 'backend_guard',
    'ui_config' => [
        'logo'=>  [
            'title'=>  '',
            'image'=>  '',
        ],
        'menu'=>  [
            'data'=>  '',
            'method'=>  'GET',
            'accordion'=>  true,
            'collapse'=>  false,
            'control'=>  false,
            'controlWidth'=>  500,
            'select'=>  '10',
            'async'=>  true,
        ],
        'tab'=>  [
            'enable'=> true,
            'keepState'=>  true,
            'session'=>  true,
            'preload'=>  false,
            'max'=>  '30',
            'index'=>  [
                'id'=>  '10',
                'href'=>  '',
                'title'=>  '首页',
            ],
        ],
        'theme'=>  [
            'defaultColor'=>  '2',
            'defaultMenu'=>  'dark-theme',
            'defaultHeader'=>  'light-theme',
            'allowCustom'=>  true,
            'banner'=>  false,
        ],
        'colors'=>  [
            [
                'id'=>  '1',
                'color'=>  '#2d8cf0',
                'second'=>  '#ecf5ff',
            ],
            [
                'id'=>  '2',
                'color'=>  '#36b368',
                'second'=>  '#f0f9eb',
            ],
            [
                'id'=>  '3',
                'color'=>  '#f6ad55',
                'second'=>  '#fdf6ec',
            ],
            [
                'id'=>   '4',
                'color'=>  '#f56c6c',
                'second'=>  '#fef0f0',
            ],
            [
                'id'=>  '5',
                'color'=>  '#3963bc',
                'second'=>  '#ecf5ff',
            ]
        ],
        'other'=>  [
            'keepLoad'=>  '1200',
            'autoHead'=>  false,
            'footer'=>  false,
        ],
        'header'=>  [
            'message'=>  '',
        ],
    ],
];

