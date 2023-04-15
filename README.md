# README #

# Deploy Local (DOCKER)

1. Copiamos el fichero ```example.env``` en la misma carpeta, con el nombre ```.env```

2. Modificamos en el fichero ```.env``` las variables de entorno:
```

DB_HOST = db-directorio_negocios
DB_NAME = directorio_negocios
DB_USER = root
DB_PASS = root

```

3. Despliegue del servidor desarrollo docker
```bash
docker-compose up -d
```

4. Accedemos a la máquina y hacemos un composer install
- Podemos hacerlo vía Docker Desktop o vía ssh


5. Crear BBDD:
- Entramos en el panel de PHPMYADMIN y creamos una bbdd
- Ponemos el nombre de la base de datos en DB_NAME, en el fichero .env
- El puerto dependerá de la configuración realizada en el docker, el SECURE_TOKEN es el que está en el .env
- Ejecutamos las migraciones para crear las tablas de la base de datos. Accedemos al panel y abrimos la url localhost:81/executeMigrations/SECURE_TOKEN/first


### Usuario por defecto ###

* Usuario: juan@pruebas.es
* Pass: admin123
