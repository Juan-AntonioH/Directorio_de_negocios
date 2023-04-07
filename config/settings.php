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
            'public_path' => '/public/uploads/',
        ],
    ],
    'uploads' => [
        'profile_directory' => __DIR__ . '/../uploads/profiles/',
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
];

return $settings;
