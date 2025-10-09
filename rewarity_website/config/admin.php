<?php

return [
    'ensure_default_on_boot' => env('ENSURE_DEFAULT_ADMIN_ON_BOOT', true),
    'force_password_sync' => env('DEFAULT_ADMIN_FORCE_PASSWORD_SYNC', false),
    'default_admin' => [
        'email' => env('DEFAULT_ADMIN_EMAIL', 'admin@rewarity.com'),
        'name' => env('DEFAULT_ADMIN_NAME', 'Administrator'),
        'password' => env('DEFAULT_ADMIN_PASSWORD', 'Password123!'),
    ],
];
