# Documento explicativo de las migraciones de base de datos en proyecto IDASFEST.

## Instrucciones de USO:

**IMPORTANTE** No se puede **EDITAR** ningún fichero .sql de la carpeta migraciones. Pues este ya puede haber sido ejecutado en un servidor y los cambios que realices no se ejecutarán.

Siempre que se quiera realizar un cambio en la base de datos se tiene que **CREAR** un fichero nuevo.

Sobre ese fichero o ficheros nuevos, si aún no ha sido comiteado y subido al repo, puedes hacer en él los cambios que quieras y ejecutarlo las veces que quieras.

## Ejecutar las migraciones

Se pueden ejecutar de dos formas:

- **SSH**: Accedemos a la carpeta raiz del proyecto y ejecutamos el script que ejecuta las migraciones con php

```bash
cd /var/www/html/
php base_de_datos/lanzar_migraciones.php
```

## Usar las migraciones por primera vez en un software que ya tiene la base de datos instalada

1º Lanzar el comando con el flag --first=true

```bash
cd /var/www/html/
php base_de_datos/lanzar_migraciones.php --first=true
```

2º Ejecutar las migraciones

```bash
php base_de_datos/lanzar_migraciones.php
```

## Crear migraciones

- 1º Crear un fichero .sql en la carpeta base_de_datos/migraciones
- 2º El nombre del fichero tiene que ser la fecha actual, hora y seguido de algún texto descriptivo: AAAA_MM_DD_HHMM_crear_tabla_prueba.sql
- 2º En el contenido del fichero solo puede haber código sql.
- 4º No puede haber otro fichero que se llame igual

## Funcionamiento

Al ejecutar las migraciones, estas se registran en la tabla "nombredeevento_migraciones", cualquier migracion en esa tabla se da por hecho que ya está ejecutada y no se volverá a ejecutar.
Si la migración falla, no se guarda como ejecutada.
Si queremos ejecutar una migración 2 veces porque hemos corregido algo, hay que entrar a base de datos, eliminar el registro de esa migración y volver a ejecutar las migraciones.

