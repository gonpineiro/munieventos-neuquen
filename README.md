# App Eventos NQN

#### [Repositorio](https://github.com/DamianCabrio/JUNTAR) originalmente del sitio web [JUNTAR](https://juntar.fi.uncoma.edu.ar/)

### ✨ Iniciar Proyecto Localmente
Tener en cuenta que este proceso va a tardar un poco la primera vez que lo corras, las imagenes de Docker se cacheany el proceso de levantar y bajar el proyecto se agiliza\

- Abrir Consola de Comandos en la direccion del proyecto y correr:
    - `docker-compose up --build -d`
    + `docker-compose run backend composer install`
    * `docker-compose run backend php /app/init` (seleccionar ambiente para Development y continuar)

 - Ajustar la config. de components['db'] en common/config/main-local.php acorde a la DB que quieras sincronizar al proyecto.\
En este ejemplo usamos la DB creada durante el primer comando que corrimos, cuya config. inicial se encuentra en el archivo *docker-compose.yml*
   ```
    'dsn' => 'mysql:host=mysql;dbname=yii2advanced',
    'username' => 'yii2advanced',
    'password' => 'secret',
    ```
 - Correr los SQL *sql/pwa_juntar_creacional.sql* y *sql/pwa_juntar_poblacional.sql* en algun administrador de DBs para crear y poblar las tablas de ejemplo

Finalmente podras dirijirte a [localhost:21008](http://localhost:21008/) para el administrador, o [localhost:20080](http://localhost:20008/) para la app nomal (llamada 'frontend' en el proyecto)
