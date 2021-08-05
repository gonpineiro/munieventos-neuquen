# App Eventos NQN

#### [Repositorio](https://github.com/DamianCabrio/JUNTAR) originalmente del sitio web [JUNTAR](https://juntar.fi.uncoma.edu.ar/)

### ✨ Iniciar Proyecto Localmente
Tener en cuenta que este proceso va a tardar un poco la primera vez que lo corras, las imagenes de Docker se cachean y el proceso de levantar y bajar el proyecto se agiliza

- Asegurarse de tener Docker instalado y corriendo
- Abrir Consola de Comandos en la direccion del proyecto y correr:
    - `docker-compose up --build -d`
    + `docker-compose run backend composer update`
    + `docker-compose run backend composer install`
    * `docker-compose run backend php /app/init` o  (Seleccionar ambiente para Development (Elegir `0` luego `yes`) y continuar)

 - Ajustar la config. de components['db'] en `common/config/main-local.php` acorde a la DB que quieras sincronizar al proyecto.\
En este ejemplo usamos la DB creada durante el primer comando que corrimos, cuya config. inicial se encuentra en el archivo *docker-compose.yml*
   ```
    'dsn' => 'mysql:host=mysql;dbname=yii2advanced',
    'username' => 'yii2advanced',
    'password' => 'secret',
    ```
 - En algun administrador de DBs (ej. DBeaver), conectarse a `localhost:3306` con usuario y contraseña usadas para el paso anterior, y correr los SQL *sql/pwa_juntar_creacional.sql* y *sql/pwa_juntar_poblacional.sql* (ignorar el aviso que te salta al correrlos).

### Finalmente
Podras dirijirte a [localhost:21008](http://localhost:21008/) para el administrador, o [localhost:20080](http://localhost:20008/) para la app nomal (llamada 'frontend' en el proyecto)
