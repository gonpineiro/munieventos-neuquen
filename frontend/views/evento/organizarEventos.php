<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;
use yii\bootstrap4\LinkPager;
use yii\helpers\Url;

$this->title = 'Eventos Muni Neuquén';
?>
<div class="site-index">

    <div class="body-content">
        <header class="hero gradient-hero padding_hero">
            <div class="center-content">
                <h2 class="text-white text-uppercase">Gestionar Mis Eventos</h2>
            </div>
        </header>
        <section class="bg_muni_azul_5" style="padding: 45px 15px 30px;" id="events">
            <div class="container">
                <form action="#events">
                    <div class="form-group row" style="margin-bottom: 0px;">

                        <div class="col-sm-12 col-md-4 mb-3">

                            <select name="estadoEvento" class="custom-select custom-select-lg" onchange="this.form.submit()">
                                <option <?= (isset($_GET["estadoEvento"]) && $_GET["estadoEvento"] == 0) ? "selected" : "" ?> value="0">Estado Activo
                                </option>
                                <option <?= (isset($_GET["estadoEvento"]) && $_GET["estadoEvento"] == 1) ? "selected" : "" ?> value="1">Estado Borrador
                                </option>
                                <option <?= (isset($_GET["estadoEvento"]) && $_GET["estadoEvento"] == 2) ? "selected" : "" ?> value="2">Estado Finalizado
                                </option>
                            </select>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-3">
                            <input class="form-control-lg full_width" type="search" placeholder="Buscar" name="s" value="<?= isset($_GET["s"]) ? $_GET["s"] : "" ?>">
                        </div>

                        <div class="col-sm-12 col-md-2 mb-3">
                            <button class="btn btn-lg full_width" type="submit">Buscar</button>
                        </div>
                        <div class="col-sm-12 col-md-2 mb-3">
                            <?= Html::a('Restablecer', ["evento/organizar-eventos#events"], ['class' => 'btn btn-secondary btn-lg full_width']); ?>
                        </div>

                    </div>
                </form>
            </div>
        </section>
        <div class="container padding_section pt-5">
            <?php if (count($eventos) != 0) : ?>
                <div class="card-columns">
                    <?php foreach ($eventos as $evento) : ?>
                        <div class='card shadow bg-light mb-4'>
                            <?= Html::a(Html::img(Url::base('') . '/' . Html::encode($evento["imgLogo"]), ["class" => "card-img-top"]), ['/eventos/ver-evento/' . $evento->nombreCortoEvento]) ?>
                            <div class='card-body'>
                                <h4 class='card-title font-weight-bold text_muni_azul_5'><?= Html::encode($evento["nombreEvento"]) ?></h4>
                                <h5 class='card-title text-dark'><?= Html::encode("Organizador: " . $evento["idUsuario0"]["nombre"] . " " . $evento["idUsuario0"]["apellido"]) ?></h5>
                                <h5 class='card-title text-muted'><?= Html::encode(date('d/m/Y', strtotime($evento["fechaInicioEvento"]))) ?></h5>
                                <hr>
                                <p class='card-text font-weight-light'><?= Html::encode($evento["lugar"]) ?></p>
                                <p class='card-text font-weight-light'><?= Html::decode(strtok(wordwrap($evento["descripcionEvento"], 100, "...\n"), "\n")) ?> </p>
                                <?= Html::a('Más Información', ['/eventos/ver-evento/' . $evento->nombreCortoEvento], ['class' => 'btn btn-primary btn-lg full_width']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="row py-5 pagination-lg pagination_center">
                    <?= // display pagination
                    LinkPager::widget([
                        'pagination' => $pages,
                        "disableCurrentPageButton" => true,
                    ]);
                    ?>
                </div>
        </div>

    <?php else : ?>
        <div class="row">
            <h2 class="text-white text-uppercase">No se encontraron eventos, vuelva a intentar.</h2><br>
        </div>
    <?php endif; ?>
    </div>
</div>
</div>