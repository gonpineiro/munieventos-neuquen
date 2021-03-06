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
| MySql      | 3326          | 3326          | 3306             | 3306             |

<b>Frontend:</b> aplicacion principal en el cual los usuarios tiene acceso. [localhost:21008](http://localhost:21008/)
<b>Backend:</b> aplicacion secundaria para la adminstración. [localhost:20080](http://localhost:20008/)

#### Conectarse a los servidores de la municipalidad

- Con VPN activada conetarse por ssh a la maquina de la siguiente forma: 
    - ssh modernizacion@128.53.80.108
    - ssh modernizacion@128.53.1.9
    - Password: Moderna20

#### Configuración Database Tool (MySQL Workbench o similar)
- Se crea una nueva MySQL Connection
- Connection Method: Standard TCP/IP over SSH
- SSH Hostname: 128.53.1.9
- SSH Username: modernizacion
- SSH Password: Moderna20
- MySQL Hostname: 127.0.0.1
- MySQL Server Port: 3306
- Username: usereventos
- Password: Eventual.2020


#### Configuración del proyecto
 Dentro de `common/config/main-local.php` se debe configurar el acceso a la base de datos y la configuración del correo electronico del proyecto

#### Habilitar modo debug de Yii2
Dentro de `frontend/config/main-local.php` se agrega lo siguiente:
 ```php
if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'] /* importante */
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}
 ```
 
 #### Actualizaciones en producción

Ya dentro del servidor de la municipalidad se hacen los pull del repositorio main con super usuario. El proyecto se encuentra dentro de /var/www/eventos.
 ```bash
  modernizacion@eventosserver:/var/www/eventos$ sudo git pull origin main
 ```
 #### GitHub Access Token
Al momento de hacer un pull, se pide la contraseña del servidor, nombre de usuario GitHub y "contraseña". Esta última es un Access Token, que se crea desde [GitHub](https://github.com/settings/tokens). 
Para más información [GitHubDocs](https://docs.github.com/es/authentication/keeping-your-account-and-data-secure/creating-a-personal-access-token).

#### Integración con WebLogin Municipalidad

Se debe modificar el siguente archivo de la librearia de yii2: `\vendor\yiisoft\yii2\base\Application.php`
 - Agregamos los siguentes `use` 

 ```php
  use backend\models\RegistrarUsuarioForm;
  use common\models\LoginForm;
  use common\models\WSWebLogin;
  use common\models\User;
 ```

 - Dentro del metodo `run()` antes del `try catch` se debe agregar el siguente código:

 ```php
  if (isset($_GET['SESSIONKEY']) && isset($_GET['APP'])) {
    $usuarioWsLogin = new WSWebLogin($_GET['SESSIONKEY'], $_GET['APP']);
    if (!$usuarioWsLogin->error) {
        $usuario = User::findByEmail($usuarioWsLogin->email);
        if (!$usuario) {
            $usuarioModelo = new RegistrarUsuarioForm();
            $usuarioModelo->nombre = $usuarioWsLogin->nombreApellido[1];
            $usuarioModelo->apellido = $usuarioWsLogin->nombreApellido[0];
            $usuarioModelo->pais = $usuarioWsLogin->pais;
            $usuarioModelo->email = $usuarioWsLogin->email;
            $usuarioModelo->registrar($usuarioWsLogin->password);
        }
        $loginModel = new LoginForm();
        $loginModel->email = $usuarioWsLogin->email;
        $loginModel->password = $usuarioWsLogin->password;
        $loginModel->login();
    } else {
        header('Location: https://weblogin.muninqn.gov.ar');
        exit();
    }
}
 ```

#### Instalación de CURL y reinicio del servidores

```sh
  sudo apt-get install curl -y
  sudo apt-get install php[tu-version]-curl -y
  sudo service nginx restart
```
