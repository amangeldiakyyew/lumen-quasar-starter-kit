<?php

return [
    'defaults' => [
        'guard' => env('API_USER_AUTH_GUARD'),
        'passwords' => 'users',
    ],
    'guards' => [
        env('API_USER_AUTH_GUARD') => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
        env('API_ADMIN_AUTH_GUARD') => [
            'driver' => 'jwt',
            'provider' => 'admins',
        ],

    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \App\Models\UserModel::class
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => \App\Models\AdminModel::class
        ]
    ]
];
