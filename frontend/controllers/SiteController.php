<?php

namespace frontend\controllers;

use backend\models\RegistrarUsuarioForm;
use common\models\LoginForm;
use common\models\User;
use common\models\WSWebLogin;
use Exception;
use frontend\models\CategoriaEvento;
use frontend\models\ContactForm;
use frontend\models\Evento;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

//use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors['access'] = [
            //utilizamos el filtro AccessControl
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'actions' => [
                        'login',
                        'signup',
                        'error',
                        'contact',
                        'captcha',
                        'about',
                        'request-password-reset',
                        'PasswordReset',
                        'resend-verification-email',
                        'verify-email',
                        'reset-password',
                        'index',
                        'buscar-provincias',
                        'buscar-localidades',
                        'buscar-barrios',
                    ],
                    'roles' => ['?'], // <----- guest
                ],
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        //                        $module = Yii::$app->controller->module->id;
                        $action = Yii::$app->controller->action->id;        //guardamos la accion (vista) que se intenta acceder
                        $controller = Yii::$app->controller->id;            //guardamos el controlador del cual se consulta
                        //                        $route = "$module/$controller/$action";
                        $route = "$controller/$action";                     //generamos la ruta que se busca acceder
                        //                        $post = Yii::$app->request->post();
                        //preguntamos si el usuario tiene los permisos para visitar el sitio
                        //                        if (Yii::$app->user->can($route, ['post' => $post])) {
                        if (Yii::$app->user->can($route)) {
                            //                            return $this->goHome();
                            return true;
                        }
                    }
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     *
     */
    public function actionIndex()
    {
        $categoriasEventos = CategoriaEvento::find()
            ->select(['descripcionCategoria'])
            ->indexBy('idCategoriaEvento')
            ->column();

        $request = Yii::$app->request;
        $busqueda = $request->get("s", "");
        $orden = $request->get("orden", "");
        $fechaInicio = $request->get("fechaInicioEvento", "");
        $categoriaId = $request->get('categoriasEventos');
        $nombreCategoria = CategoriaEvento::find()
            ->select(['descripcionCategoria'])
            ->where(['idCategoriaEvento' => $categoriaId])
            ->column();
        if (isset($nombreCategoria[0])) {
            $nombreCategoria = $nombreCategoria[0];
        } else {
            $nombreCategoria = "Elegir...";
        }
        if ($orden != "") {
            $ordenSQL = $orden == "0" ? "fechaInicioEvento DESC" : "fechaCreacionEvento DESC";
        } else {
            $ordenSQL = "fechaInicioEvento DESC";
        }

        if ($busqueda != "" && ($fechaInicio == "" || $fechaInicio == null) && ($categoriaId == "" || $categoriaId == null)) {
            $eventos = Evento::find()
                ->innerJoin('usuario', 'usuario.idUsuario=evento.idUsuario')
                ->where(["idEstadoEvento" => 1])
                ->orwhere(["idEstadoEvento" => 3])
                ->andwhere(["like", "nombre", $busqueda])
                ->orwhere(["like", "apellido", $busqueda])
                ->orwhere(["like", "nombreEvento", $busqueda])
                ->orderBy($ordenSQL);
        } else {
            if ($fechaInicio != "" || $fechaInicio != null) {
                if ($categoriaId != "" || $categoriaId != null) {
                    $eventos = Evento::find()
                        ->orderBy($ordenSQL)
                        ->where(["idEstadoEvento" => 1])
                        ->orwhere(["idEstadoEvento" => 3])
                        ->where(["fechaInicioEvento" => $fechaInicio])
                        ->andwhere(['idCategoriaEvento' => $categoriaId]);
                } else {
                    $eventos = Evento::find()
                        ->orderBy($ordenSQL)
                        ->where(["idEstadoEvento" => 1])
                        ->orwhere(["idEstadoEvento" => 3])
                        ->where(["fechaInicioEvento" => $fechaInicio]);
                }
            } else {
                if ($categoriaId != "" || $categoriaId != null) {
                    $eventos = Evento::find()->orderBy($ordenSQL)->where(['idCategoriaEvento' => $categoriaId])->andwhere(["idEstadoEvento" => 1])->orwhere(["idEstadoEvento" => 3]);
                } else {
                    $eventos = Evento::find()->orderBy($ordenSQL)->where(["idEstadoEvento" => 1])->orwhere(["idEstadoEvento" => 3]);
                }
            }
        }

        //Paginaci??n para 6 eventos por pagina
        $countQuery = clone $eventos;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->pageSize = 6;
        //$pages->applyLimit = $countQuery->count();
        $models = $eventos->offset($pages->offset)
            ->limit($pages->limit)
            ->all();


        return $this->render('index', ["eventos" => $models, 'pages' => $pages, 'categoriasEventos' => $categoriasEventos, 'nombreCategoria' => $nombreCategoria]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) /* && $model->validate()  *//* &&  */) {

            if ($model->externalLogin == 'externalLogin') {
                $token = $this->webLogin($model->email, $model->password);
                $usuarioWsLogin = new WSWebLogin($token, 63);
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
                    $model->email = $usuarioWsLogin->email;
                    $model->password = $usuarioWsLogin->password;
                    $model->login();
                } else {
                    header('Location: https://weblogin.muninqn.gov.ar');
                    exit();
                }
            } else {
                if ($model->login()) {
                    return $this->goBack(Url::previous());
                }
            }
            return $this->goBack(Url::previous());
        } else {
            $model->password = '';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    private function webLogin($user, $pass)
    {
        $params = ["userName" => $user, 'userPass' => $pass];
        $url = 'https://weblogin.muninqn.gov.ar/api_v1/getToken';
        $headers = array(
            "Content-Type: application/json",
        );
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => json_encode($params),
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_SSL_VERIFYPEER => false,

            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $usuario = json_decode($response, true);
            return $usuario['securityToken'];
        } catch (Exception $e) {
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        /* Implementacion WebLogin */
        /* Si se redirige al weblogin, no cierra sesi??n, yendo a goHome se termina. */
        //header('Location: https://weblogin.muninqn.gov.ar');
        //exit();

        return $this->goHome();
    }

    public function actionSlug($slug)
    {
        $model = Evento::find()->where(['nombreCortoEvento' => $slug])->one();
        if (!is_null($model)) {
            return $this->render('evento/verEvento', [
                'evento' => $model,
            ]);
        } else {
            return $this->redirect('/site/index');
        }
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', '<h2> Consulta Recibida. </h2>'
                    . '<p> Muchas gracias por ponerte en contacto. </p>'
                    . '<p> ??Un administrador se pondr?? en contacto para responder tus consultas lo m??s r??pido posible! </p>');
            } else {
                Yii::$app->session->setFlash('error', '<h2> Algo sali?? mal.. </h2> '
                    . '<p> Ocurri?? un error mientras se enviaba su consulta. Por favor, int??ntelo nuevamente. </p>'
                    . '<p> Si cree que es un error del servidor, por favor, contacte con un administrador </p>');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        //obtiene datos paises
        $dataCountry = file_get_contents("json/paises.json");
        $paises = json_decode($dataCountry, true);
        $paises = ArrayHelper::map($paises['countries'], 'id', 'name');
        $paises = $this->conversionAutocomplete($paises);

        //obtiene datos barrios
        $dataBarrio = file_get_contents("json/barrios.json");
        $barrios = json_decode($dataBarrio, true);
        $barrios = ArrayHelper::map($barrios['barrios'], 'id', 'nombre');
        $barrios = $this->conversionAutocomplete($barrios);
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->signup()) {
            Yii::$app->session->setFlash('success', '<h2> ??S??lo queda confirmar tu correo! </h2>'
                . '<p> Muchas gracias por registrarte. Por favor, revisa tu direcci??n de correo para confirmar tu cuenta. </p>');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
            'paises' => $paises,
            'barrios' => $barrios
        ]);
    }

    /**
     * Conversion del datos para autocompletar en campos
     *
     * @return mixed
     */
    public function conversionAutocomplete($array)
    {
        $autocomplete = array();
        foreach ($array as $id => $nombre) {
            array_push($autocomplete, ['value' => $nombre, 'label' => $nombre]);
        }
        return $autocomplete;
    }

    public function actionBuscarProvincias()
    {
        $provincias = null;
        if (Yii::$app->request->post('pais') != null) {

            //almacena el par??metro esperado
            $pais = Yii::$app->request->post('pais');

            //define el tipo de respuesta del metodo
            Yii::$app->response->format = Response::FORMAT_JSON;

            //obtiene la data de las provincias del json
            $dataProvincias = file_get_contents("json/provincias.json");
            $provincias = json_decode($dataProvincias, true);

            //busca el indice del pais
            $indexPais = null;
            foreach ($provincias as $index => $unPais) {
                if (array_search($pais, $unPais)) {
                    $indexPais = $index;
                }
            }
            // Conversi??n de datos para obtener las provincias
            $provincias = ArrayHelper::map($provincias[$indexPais]['provincias'], 'id', 'nombre');
            $provincias = $this->conversionAutocomplete($provincias);
        }
        return $provincias;
    }

    public function actionBuscarLocalidades()
    {
        $localidades = null;
        if (Yii::$app->request->post('provincia') != null) {

            //almacena el par??metro esperado
            $provincia = Yii::$app->request->post('provincia');

            //define el tipo de respuesta del metodo
            Yii::$app->response->format = Response::FORMAT_JSON;

            //obtiene la data de las localidades del json
            $dataLocalidades = file_get_contents("json/localidades.json");
            $localidades = json_decode($dataLocalidades, true);

            //busca el indice de la provincia
            $indexProvincia = null;
            foreach ($localidades as $index => $unaProvincia) {
                if (array_search($provincia, $unaProvincia)) {
                    $indexProvincia = $index;
                }
            }
            //Conversi??n de datos para obtener las localidades 
            $localidades = ArrayHelper::map($localidades[$indexProvincia]['ciudades'], 'id', 'nombre');
            $localidades = $this->conversionAutocomplete($localidades);
        }
        return $localidades;
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', '<h2> ??Ya queda poco! </h2>'
                    . '<p> Revisa tu cuenta de correo y sigue las instrucciones que te enviamos para poder cambiar tu contrase??a. </p>');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', '<h2> Algo sali?? mal.. </h2>'
                    . '<p> Lo sentimos, ocurri?? un error con el enlace del correo. </p>'
                    . '<p> Si cree que esto es un error del servidor, por favor, contacte con un administrador </p>');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', '<h2> Cambio realizado exitosamente </h2>'
                . '<p> La nueva contrase??a fue guardada. </p>');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', '<h2> ??Confirmaci??n exitosa! </h2>'
                    . '<p> Su direcci??n de correo ha sido confirmada exitosamente. Ya puede acceder al contenido de la plataforma </p>');

                if (!Yii::$app->user->can("Registrado")) {
                    //iniciamos authManager
                    $auth = Yii::$app->authManager;
                    //indicamos el rol que deseamos asignarle al usuario
                    $usuarioRegistrado = $auth->createRole('Registrado');
                    // Asignamos el rol al usuario registrado
                    $auth->assign($usuarioRegistrado, (Yii::$app->user->id));
                    //destruimos la referencha al authManager
                    $auth = null;
                }

                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', '<h2> Algo sali?? mal... </h2>'
            . '<p> Lo sentimos, no fuimos capaces de verificar su cuenta a partir del mail enviado. </p>'
            . '<p> Si cree que esto se debe a un error en el servidor, por favor, contacte con un administrador. </p>');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', '<h2> Email de verificaci??n reenviado </h2>'
                    . '<p> Revisa tu cuenta de correo y sigue las instrucciones para poder activar tu cuenta. </p>');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', '<h2> Algo sali?? mal... </h2>'
                . '<p> Lo sentimos, no fuimos capaces de reenviar el email de confirmaci??n a la cuenta ingresada </p>'
                . '<p> Si cree que esto se debe a un error en el servidor, por favor, contacte con un administrador </p>');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionExternalLog()
    {
        die('hola');
    }
}
