<?php

$debug = $_ENV['DEBUG'];

// Should be set to 0 in production
error_reporting($debug != 'false' ? E_ALL : 0);

// Should be set to '0' in production
ini_set('display_errors', $debug != 'false' ? E_ALL : 0);
ini_set('error_log', '../log/' . date('Y-m-d') . '.log');

$settings = [
    'app' => [
        'name' => $_ENV['APP_NAME'],
        'logo' => $_ENV['APP_LOGO'],
        'default_lang' => $_ENV['APP_DEFAULT_LANG'],
    ],
    'twig' => [
        'templates_path' => __DIR__ . '/../templates/',
        'cache_path' => __DIR__ . '/../twig_cache/',
        'uploads' => [
            'profile_path' => '/uploads/profiles/',
            'artist_path' => '/uploads/artists/',
            'public_path' => '/public/uploads/',
        ],
    ],
    'uploads' => [
        'profile_directory' => __DIR__ . '/../uploads/profiles/',
        'news_directory' => __DIR__ . '/../uploads/news/',
        'newsThumbnail_directory' => __DIR__ . '/../uploads/newsThumbnail/',
        'artist_directory' => __DIR__ . '/../uploads/artists/',
        'thumbnail_directory' => __DIR__ . '/../uploads/thumbnails/',
    ],
    'migrations' => [
        'token' => $_ENV['SECURE_TOKEN'],
    ],
    'db' => [
        'name' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'pass' => $_ENV['DB_PASS'],
        'host' => $_ENV['DB_HOST'],
        'charset' => $_ENV['CHARSET'],
        'collate' => $_ENV['COLLATE'],
    ],

    'smtp' => [
        'host' => 'email-smtp.us-west-2.amazonaws.com',  // SMTP Host
        'port' => '465',  // SMTP Port
        'username' => 'AKIAQEJVRWSIAQ76ZWWF',  // SMTP Username
        'password' => 'BKyIdNje0b4Xk4rd4+pPrvHVc2Z2VjKbCc/8isIx3SHN',  // SMTP Password
        'protocol' => 'ssl',   // SSL or TLS
        'default_from_addres' => 'no-reply@casfid.es',
        'default_from_name' => 'MadCool',
    ],
];

return $settings;
