<?php
/* @var $this View */

/* @var $content string */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use frontend\models\ImagenPerfil;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::$app->charset; ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#050714" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <?php $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/ico', 'href' => Url::base('http') . '/favicon.png']); ?>

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - Municipalidad de Neuquén</title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Html::img('@web/images/logo-03.svg', ['style' => 'height:30px']),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md fixed-top shadow-sm',
                'style' => 'background-color: white',
            ],
        ]);
        $menuItems = [
            ['label' => 'Inicio', 'url' => ['/site/index']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Registrarse', 'url' => ['/site/signup']];
            $menuItems[] = ['label' => 'Ingresar', 'url' => ['/site/login']];
        } else {
            // Opciones solo para usuario con rol organizador 
            if (Yii::$app->user->can('Organizador')) {
                $menuItems[] = ['label' => 'Crear Evento', 'url' => ['/evento/cargar-evento']];
                $menuItems[] = ['label' => 'Organizar Eventos', 'url' => ['/evento/organizar-eventos']];
            }
            //Logout

            /** @var TYPE_NAME $urlImagenPerfil */
            $profileImageModel = ImagenPerfil::findOne(['idUsuario' => Yii::$app->user->identity->idUsuario]);

            //            $urlImagenPerfil = Url::base(true) . "/profile/images/" . Yii::$app->user->identity->id . "-" . Yii::$app->user->identity->nombre . ".jpg";
            if ($profileImageModel != null) {
                $urlImagenPerfil = $profileImageModel->rutaImagenPerfil;
                if (file_exists(substr($urlImagenPerfil, 1))) {
                    $imgPerfil = Url::base(true) . $profileImageModel->rutaImagenPerfil;
                } else {
                    $imgPerfil = '@web/iconos/person-circle-w.svg';
                }
            } else {
                $imgPerfil = '@web/iconos/person-circle-w.svg';
            }
            $menuItems[] = [
                'label' => Html::img($imgPerfil, ['class' => 'ml-1', "alt" => "Cuenta", "width" => "35", "height" => "35", "title" => "Cuenta", "role" => "img", "style" => "margin: -4px 8px 0 0; border-top-left-radius: 50% 50%;
  border-top-right-radius: 50% 50%;
  border-bottom-right-radius: 50% 50%;
  border-bottom-left-radius: 50% 50%;"]),
                'items' => [
                    ['label' => Yii::$app->user->identity->nombre . ' ' . Yii::$app->user->identity->apellido],
                    ['label' => 'Mi Perfil', 'url' => ['/cuenta/profile'], 'linkOptions' => ['class' => 'yolo']],

                    ['label' => 'Mis Inscripciones', 'url' => ['/cuenta/mis-inscripciones-a-eventos']],
                    [
                        "label" => "Cerrar Sesión",
                        "url" => ["/site/logout"],
                        "linkOptions" => [
                            "data-method" => "post",
                        ]
                    ],
                ],
            ];
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-collapse justify-content-end'],
            'items' => $menuItems,
            'encodeLabels' => false,
        ]);
        NavBar::end();
        ?>


        <?php
        echo Alert::widget([
            'options' => ['class' => 'text-center']
        ])
        ?>
        <?php echo $content ?>
    </div>

    <section class="bg_muni_azul_5 text-light">
        <div class="container">

            <div class="row">
                <div class="col-12 col-md-7">
                    <?= Html::img('@web/images/logo-03-negativo.svg', ['class' => 'img-fluid my-3', 'style' => 'width:300px;']); ?>
                </div>
                <div class="col-12 col-md-5">
                    <h4 class="white-text">Municipalidad de Neuquén</h4>
                    <p>Dirección: Avda. Argentina y Roca</p>
                    <p>Teléfono: <a class="text-white" href="tel:+5402994491200">+ 54 0299 449 1200</a></p>
                    <p>Email: <a class="text-white" href="mailto:munieventos@muninqn.gov.ar">munieventos@muninqn.gov.ar</a></p>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer bg_muni_azul_45 text-light">
        <div class="container-fluid">
            <div class="container">
                <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            </div>
        </div>

    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>