<?php

declare(strict_types=1);

return [
    'providers' => [
        'unitpay' => [
            'public_key' => env('UNITPAY_PUBLIC_KEY',''),
            'secret_key' => env('UNITPAY_SECRET_KEY',''),
        ],
        'yookassa' => [
            'login' => env('YOOKASSA_SHOP_ID', ''),
            'password' => env('YOOKASSA_SECRET_KEY', ''),
        ]
    ]
];
