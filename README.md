## App Eventos NQN

#### [Repositorio](https://github.com/DamianCabrio/JUNTAR) originalmente del sitio web [JUNTAR](https://juntar.fi.uncoma.edu.ar/)

#### ✨ Iniciar Proyecto Localmente

Tener en cuenta que este proceso va a tardar un poco la primera vez que lo corras, las imagenes de Docker se cachean y el proceso de levantar y bajar el proyecto se agiliza

- Asegurarse de tener Docker instalado y corriendo
- Abrir Consola de Comandos en la direccion del proyecto y correr:

  ```sh
   docker-compose up --build -d
   docker-compose run backend composer update
   docker-compose run backend composer install
   docker-compose run backend php /app/init
  ```

<small>Cuando se ejecuta el ultimo comando se debera seleccionar el ambiente Para Development: se debe seleccionar `0` y luego `yes`</small>

- Ajustar la config. de components['db'] en `common/config/main-local.php` acorde a la DB que quieras sincronizar al proyecto.\
  En este ejemplo usamos la DB creada durante el primer comando que corrimos, cuya config. inicial se encuentra en el archivo `docker-compose.yml`

  ```php
   'dsn' => 'mysql:host=mysql;dbname=yii2advanced',
   'username' => 'yii2advanced',
   'password' => 'secret',
  ```

- En algun administrador de DBs (ej. DBeaver), conectarse a `localhost:3306` con usuario y contraseña usadas para el paso anterior, y correr los SQL:

  ```sh
   sql/pwa_juntar_creacional.sql
   sql/pwa_juntar_poblacional.sql
  ```

#### Puertos

| Servicio   | Replica (ext) | Replica (int) | Producción (ext) | Producción (Int) |
| ---------- | ------------- | ------------- | ---------------- | ---------------- |
| Frontend\* | 20081         | 80            | 20080            | 80               |
| Backend\*  | 21081         | 80            | 21080            | 80               |
| MySql      | 3306          | 3306          | 3306             | 3306             |

<b>Frontend:</b> aplicacion principal en el cual los usuarios tiene acceso. [localhost:21008](http://localhost:21008/)
<b>Backend:</b> aplicacion secundaria para la adminstración. [localhost:20080](http://localhost:20008/)

#### Conectarse a los servidores Docker de la municipalidad

- Con VPN activada conetarse por ssh a la maquina de la siguiente forma: 
    - ssh modernizacion@128.53.80.108
    - Password: Moderna20

#### Configuración del proyecto
 Dentro de `common/config/main-local.php` se debe configurar el acceso a la base de datos y la configuración del correo electronico del proyecto