<?php

$short_options = 'f:';
$long_options = ['first:'];
$options = getopt($short_options, $long_options);

include_once __DIR__ . '/MigrationsManager.php';

echo '**************** LANZAR MIGRACIONES *******************' . PHP_EOL;
$base_dir = __DIR__ . '/migrations_files/';

$migrationManager = new MigrationsManager();

$omitir_migraciones = (isset($options['first']) && $options['first'] == 'true') || (isset($firstFromRoute) && $firstFromRoute) ? [] : $migrationManager->executedMigrations();
$migraciones = array_diff(scandir($base_dir), $omitir_migraciones);

if (count($migraciones) > 0) {
    foreach ($migraciones as $migracion) {
        if (file_exists($base_dir . $migracion)) {
            $file_extension = pathinfo($base_dir . $migracion, PATHINFO_EXTENSION);
            if ($file_extension == 'sql') {
                $migrationManager->executeMigration($base_dir, $migracion);
            }
        }
    }
} else {
    echo "\033[1;33m No hay migraciones para ejecutar\033[0m" . PHP_EOL;
}

echo '******** MIGRACIONES EJECUTADAS CORRECTAMENTE *********' . PHP_EOL;

exit;
