<?php
/* @var $this yii\web\View */

use yii\bootstrap4\Html;
use yii\bootstrap4\LinkPager;
use yii\helpers\Url;

$openGraph = Yii::$app->opengraph;

$openGraph->getBasic()
    ->setUrl(Yii::$app->request->hostInfo . Yii::$app->request->url)
    ->setTitle("Eventos Muni Neuquén")
    ->setDescription("Somos una plataforma web para gestión de eventos libre y gratuita. El sitio permite a los usuarios navegar, crear y participar de eventos. Nació como un desafío universitario y podemos asegurar que hemos llegado a la meta que teníamos como objetivo e incluso la hemos superado gracias a un gran equipo de trabajo. Licencia GNU GPL version 3")
    ->setSiteName("Eventos Muni Neuquén")
    ->setLocale('es_AR')
    ->render();

$openGraph->useTwitterCard()
    ->setCard('summary')
    ->setSite(Yii::$app->request->hostInfo . Yii::$app->request->url)
    ->render();

$openGraph->getImage()
    ->setUrl(Url::base('') . "images/juntar-logo/png/juntar-avatar-bg-b.png")
    ->setAttributes([
        'secure_url' => Url::base('') . "images/juntar-logo/png/juntar-avatar-bg-b.png",
        'width' => 100,
        'height' => 100,
        'alt' => "Logo Evento",
    ])
    ->render();

$this->title = 'Muni Eventos';
?>
<div class="site-index">
    <div class="body-content">
        <header class="hero gradient-hero">
            <div class="center-content">
                <h1 class="text-white my-5"><span class="text-mask">Muni Eventos</span></h1>
                <!-- <?= Html::img('@web/images/icono-muni-evento.png', ['class' => 'img-fluid mt-3 ', 'style' => 'width:300px']);  ?> -->
            </div>
        </header>
        <div class="bg_muni_azul_5" style="padding: 45px 15px 30px;" id="events">
            <div class="container">
                <form action="#events">
                    <div class="form-group row" style="margin-bottom: 0px;">

                        <div class="col-sm-12 col-md-4 mb-3">
                            <select name="orden" class="custom-select custom-select-lg" onchange="this.form.submit()">
                                <option <?= (isset($_GET["orden"]) && $_GET["orden"] == 0) ? "selected" : "" ?> value="0">Fecha de inicio del evento
                                </option>
                                <option <?= (isset($_GET["orden"]) && $_GET["orden"] == 1) ? "selected" : "" ?> value="1">Fecha de creación
                                </option>
                            </select>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-3">
                            <input class="form-control-lg full_width" type="search" placeholder="Buscar" name="s" value="<?= isset($_GET["s"]) ? $_GET["s"] : "" ?>">
                        </div>

                        <div class="col-sm-12 col-md-2 mb-3">
                            <button class="btn btn-secondary btn-lg full_width" type="submit">Buscar</button>
                        </div>
                        <div class="col-sm-12 col-md-2 mb-3">
                            <?= Html::a('Restablecer', ["index#events"], ['class' => 'btn btn-secondary btn-lg full_width']); ?>
                        </div>

                    </div>
                </form>
            </div>
        </div>


        <div class="container padding_section pt-5">
            <?php if (count($eventos) != 0) : ?>
                <div class="card-columns">
                    <?php foreach ($eventos as $evento) : ?>
                        <div class='card shadow bg-light mb-5'>
                            <?= Html::a(Html::img(Url::base('') . '/' . Html::encode($evento["imgLogo"]), ["class" => "card-img-top"]), ['/eventos/ver-evento/' . $evento->nombreCortoEvento]) ?>
                            <div class='card-body'>
                                <h4 class='card-title font-weight-bold text_muni_azul_5'><?= Html::encode($evento["nombreEvento"]) ?></h4>
                                <h5 class='card-title text-dark'><?= Html::encode("Organizador: " . $evento["idUsuario0"]["nombre"] . " " . $evento["idUsuario0"]["apellido"]) ?></h5>
                                <h5 class='card-title text-muted'><?= Html::encode(date('d/m/Y', strtotime($evento["fechaInicioEvento"]))) ?> <?PHP if ($evento["horaInicioEvento"] != null && $evento["horaFinEvento"] != null) {
                                                                                                                                                    echo "de " . $evento["horaInicioEvento"] . " hasta " . $evento["horaFinEvento"];
                                                                                                                                                } ?></h5>
                                <hr>
                                <p class='card-text font-weight-light'><?= Html::encode($evento["lugar"]) ?></p>
                                <p class='card-text font-weight-light'><?= Html::decode(strtok(wordwrap(strip_tags($evento["descripcionEvento"]), 250, "...\n"), "\n")) ?> </p>
                                <?= Html::a('Más Información', ['/eventos/ver-evento/' . $evento->nombreCortoEvento], ['class' => 'btn btn-primary btn-lg full_width']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="row py-5 pagination-lg pagination_center">
                    <?=
                    // display pagination
                    LinkPager::widget([
                        'pagination' => $pages,
                        "disableCurrentPageButton" => true,
                    ]);
                    ?>
                </div>
        </div>
    <?php else : ?>
        <div class="container full_width">
            <div class="row full_width">
                <h2 class="text-dark text-center text-uppercase padding_section full_width">No se encontraron eventos, vuelva a
                    intentar.</h2><br>
            </div>
        </div>
    <?php endif; ?>

    </section>
    </div>
</div>
</div>