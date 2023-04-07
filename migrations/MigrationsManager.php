<?php

class MigrationsManager
{
    private $db;

    public function __construct()
    {
        $this->loadDbConnection();
    }

    private function buildQuerys($content_file)
    {
        // Array donde almacenamos todas las querys
        $querys = [];

        $build_query = '';
        // Recorremos cada línea del fichero para construir cada query
        foreach ($content_file as $line) {
            // omitimos si es un comentario
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }

            // Añadimos la línea a la construccion de la query
            $build_query .= $line;

            // si acaba en ; es que es final de consulta y pasamos a guardar la query para construir la siguiente.
            if (substr(trim($line), -1, 1) == ';') {
                $querys[] = $build_query;
                $build_query = '';
            }
        }

        return $querys;
    }

    public function executeMigration($baseDir, $migration)
    {
        $content_file = file($baseDir . $migration);

        // Obtenemos en un array todas las consultas de la migracion
        $querys = $this->buildQuerys($content_file);

        // Ejecutamos las consultas
        foreach ($querys as $query) {
            $s = $this->db->prepare($query);

            if (!$s->execute()) {
                echo "\033[0;31m " . $migration . ': '
                    . $s->error . "\033[0m" . PHP_EOL;
                exit;
            }
        }

        $s = $this->db->prepare('
            INSERT INTO migrations 
                (migration) 
            VALUES 
                (:migration)
        ');
        $s->bindParam(':migration', $migration);

        return $s->execute();

        echo "\033[0;32m " . $migration . ' ejecutada correctamente' . "\033[0m" . PHP_EOL;
    }

    public function executedMigrations()
    {
        $executedMigrations = ['.', '..'];

        $s = $this->db->prepare('SELECT migration FROM migrations;');

        $s->execute();

        return array_merge($executedMigrations, $s->fetchAll(PDO::FETCH_COLUMN));
    }

    private function loadDbConnection()
    {
        $settings = require __DIR__ . '/settings.php';

        $dbname = $settings['dbname'];
        $user = $settings['user'];
        $pass = $settings['pass'];
        $host = $settings['host'];
        $charset = $settings['charset'];
        $collate = $settings['collate'];

        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset COLLATE $collate",
        ];

        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';';

        $this->db = new PDO($dsn, $user, $pass, $opt);
    }
}
