# README #

![Logo](https://madcoolfestival.es/images/MC22-Favicon.png)
# Servidor Backend MadCool
El proyecto contiene el backend de servidor de MadCool.
<br>
<br>

# Deploy Local (DOCKER)

1. Copiamos el fichero ```example.env``` en la misma carpeta, con el nombre ```.env```

2. Modificamos en el fichero ```.env``` las variables de entorno:
```

DB_HOST = db-madcool-app
DB_NAME = madcool_backend_app
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
- Ejecutamos las migraciones para crear las tablas de la base de datos. Accedemos al panel y abrimos la url localhost:81/admin/executeMigrations/SECURE_TOKEN/first


### Usuario por defecto ###

* Usuario: admin@casfid.es
* Pass: admin123
