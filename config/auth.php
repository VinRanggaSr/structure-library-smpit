<?php

use App\Models\Pengguna;

return [

    'defaults' => [
        'guard' => 'web',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'pengguna',
        ],
    ],

    'providers' => [
        'pengguna' => [
            'driver' => 'eloquent',
            'model' => Pengguna::class,
        ],
    ],

];
