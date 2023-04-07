<?php

function loadEnvVars()
{
    $file_env_contents = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($file_env_contents as $line) {
        if (strpos(trim($line), '#') === 0) { // no tiene en cuenta comentarios
            continue;
        }

        $find = strpos($line, '=');

        if ($find !== false) {
            $explode = explode('=', $line, 2);
            $_ENV[trim($explode[0])] = trim($explode[1]);
        }
    }
}

// Cargamos las variables de entorno
loadEnvVars();

// Si no se pueden usar variables de entorno configurar
return $settings = [
    'dbname' => $_ENV['DB_NAME'] ?: 'default_dbname',
    'user' => $_ENV['DB_USER'] ?: 'default_user',
    'pass' => $_ENV['DB_PASS'] ?: 'default_pass',
    'host' => $_ENV['DB_HOST'] ?: 'default_host',
    'charset' => $_ENV['CHARSET'] ?: 'default_charset',
    'collate' => $_ENV['COLLATE'] ?: 'default_collate',
];
