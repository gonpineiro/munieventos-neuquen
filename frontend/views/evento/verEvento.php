<?php

use PhpOffice\PhpSpreadsheet\Reader\Xml\Style;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = $evento->nombreEvento . " - Muni Eventos";

$openGraph = Yii::$app->opengraph;

$openGraph->getBasic()
    ->setUrl(Yii::$app->request->hostInfo . Yii::$app->request->url)
    ->setTitle(Html::encode($evento->nombreEvento))
    ->setDescription(Html::encode(strtok(wordwrap($evento["descripcionEvento"], 100, "...\n"))))
    ->setSiteName("Muni Eventos")
    ->setLocale('es_AR')
    ->render();

$openGraph->useTwitterCard()
    ->setCard('summary')
    ->setSite(Yii::$app->request->hostInfo . Yii::$app->request->url)
    ->setCreator(Html::encode($evento->idUsuario0->nombre . " " . $evento->idUsuario0->apellido))
    ->render();

if ($evento->imgLogo != null) {
    $openGraph->getImage()
        ->setUrl(Url::base('') . Html::encode($evento->imgLogo))
        ->setAttributes([
            'secure_url' => Url::base('') . Html::encode($evento->imgLogo),
            'width' => 100,
            'height' => 100,
            'alt' => "Logo Evento",
        ])
        ->render();
}

if ($evento->imgFlyer != null) {
    $flyer = Url::base('') . '/' . $evento->imgFlyer;
    /* var del flyer archivo para bajarlo */
} else {
    $flyer = "(Flyer no cargado o en construcción)";
}
if ($evento->imgLogo != null) {
    $logo = '<img class="full_width" src=' . Url::base('') . '/' . $evento->imgLogo . '>';
} else {
    $logo = "(Logo no cargado o en construcción)";
}

if ($evento->preInscripcion == 0) {
    $preInscripcion = "No requiere preinscipción";
} else {
    $preInscripcion = "<b style='color:#000;'>*Requiere preinscipción*</b>";
}
if ($evento->codigoAcreditacion != null) {
    $codAcreditacion = $evento->codigoAcreditacion;
} else {
    $codAcreditacion = "Código no cargado o en construcción";
}

if ($evento->fechaCreacionEvento != null) {
    $fechaPublicacion = $evento->fechaCreacionEvento;
} else {
    $fechaPublicacion = "Evento no publicado";
}
if ($evento->horaInicioEvento != null) {
    $horaInicioEvento = $evento->horaInicioEvento;
} else {
    $horaInicioEvento = null;
}
if ($evento->horaFinEvento != null) {
    $horaFinEvento = $evento->horaFinEvento;
} else {
    $horaFinEvento = "";
}
if ($evento->fechaLimiteInscripcion != null) {
    $fechaLimite = $evento->fechaLimiteInscripcion;
} else {
    $fechaLimite = "No posee inscripción";
}

$categoriaEvento = $evento->idCategoriaEvento0->descripcionCategoria;
$modalidadEvento = $evento->idModalidadEvento0->descripcionModalidad;
$estadoEvento = $evento->idEstadoEvento0->descripcionEstado;

$organizadorEvento = $evento->idUsuario0->nombre . " " . $evento->idUsuario0->apellido;
$organizadorEmailEvento = $evento->idUsuario0->email;

?>
<div class="evento-view ">

    <header class="hero gradient-hero">
        <div class="container-fluid center-content text-center padding_hero text-white">
            <h1 class="text-white text-uppercase"><span class="text-mask"><?= $evento->nombreEvento ?></span></h1>
            <div class="row">
                <div class="col text-center">

                    <h4 class="font-weight-light"><span class="text-mask"><i class="material-icons large align-middle text-white">date_range</i> <?= date("d-m-Y", strtotime($evento->fechaInicioEvento)) ?></span></h4>

                    <?PHP
                    if (!is_null($horaInicioEvento)) { ?>
                        <h4 class="font-weight-light"><span class="text-mask"><i class='material-icons large align-middle text-white'>access_time</i> <?= $horaInicioEvento . " - " . $horaFinEvento ?></span></h4>
                    <?PHP } ?>


                    <h4 class="font-weight-light"><span class="text-mask"><i class="material-icons large align-middle text-white">location_on</i> <?= $evento->lugar ?></span></h4>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid bg_muni_azul_45 pb-5">
        <div id="evento" class="padding_hero bg_muni_half_azul_45 rounded-bottom">
            <div class="container">
                <?php if ($evento->fechaFinEvento < date("Y-m-d") || $evento->idEstadoEvento == 3) { ?>
                    <div class="alert alert-warning text-center b_corners" role="alert">
                        <b>EL EVENTO SE ENCUENTRA FINALIZADO
                            <?PHP if ($evento->fechaFinEvento <= date("Y-m-d") && $estadoEventoInscripcion == "yaAcreditado") {
                                echo "Y HAS ASISTIDO";
                            }
                            ?></b>
                    </div>
                <?php } ?>
                <div class="card bg-white">
                    <?php if ($esDueño) { ?>
                        <div class="card-header bg_muni_azul_4">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group mr-2 clearfix" role="group" aria-label="First group">
                                    <?= Html::a(' <i class="material-icons" style="padding-top:7px">edit</i>', ['/eventos/editar-evento/' . $evento->nombreCortoEvento], ['class' => 'text-light btn btn-light']) ?>
                                </div>
                                <div class="btn-group" role="group" aria-label="Second group">
                                    <button type="button" class="btn btn_estado">
                                        Evento <?php echo $estadoEvento ?></button>
                                </div>

                                <?php
                                if (($evento->idEstadoEvento) == 4) {
                                ?>
                                    <div class="btn-group" role="group" aria-label="Third group">
                                        <button type="button" class="btn btn-light" data-toggle="modal" data-target="#finalizar">Finalizar</button>
                                        <button type="button" class="btn btn-light" data-toggle="modal" data-target="#publicar">Publicar</button>
                                    </div>
                                    <!-- Button trigger modal -->

                                    <!-- Modal -->
                                    <div class="modal fade" id="finalizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Atención</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Está seguro de querer finalizar su evento?</p>
                                                    <p>No será visible en los lanzamientos de la plataforma, dejará de
                                                        estar disponible para las inscripciones y no podrá volver a
                                                        publicarlo</p>
                                                    <!-- <span class="float-right font-weight-bold">Juntar</span> -->
                                                </div>
                                                <div class="modal-footer">
                                                    <?= Html::a('Si', ['eventos/finalizar-evento/' . $evento->nombreCortoEvento], ['class' => 'btn']) ?>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Button trigger modal -->

                                    <!-- Modal -->
                                    <div class="modal fade" id="publicar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Atención</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Está seguro de querer publicar su evento?</p>
                                                    <p>Será visible en los lanzamientos de la plataforma y pasará a
                                                        estar disponible para las inscripciones</p>
                                                    <!-- <span class="float-right font-weight-bold">Juntar</span> -->
                                                </div>
                                                <div class="modal-footer">
                                                    <?= Html::a('Si', ['eventos/publicar-evento/' . $evento->nombreCortoEvento], ['class' => 'btn']) ?>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif (($evento->idEstadoEvento) == 1) {
                                ?>
                                    <div class="btn-group" role="group" aria-label="Fourth group">
                                        <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#finalizar">Finalizar
                                        </button>
                                        <?php if ($evento->fechaFinEvento > date("Y-m-d")) : ?>
                                            <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#publicar">Suspender
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Button trigger modal -->


                                    <!-- Modal -->
                                    <div class="modal fade" id="finalizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Atención</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Está seguro de querer finalizar su evento?</p>
                                                    <p>No será visible en los lanzamientos de la plataforma, dejará de
                                                        estar disponible para las inscripciones y no podrá volver a
                                                        publicarlo</p>
                                                    <!-- <span class="float-right font-weight-bold">Juntar</span> -->
                                                </div>
                                                <div class="modal-footer">
                                                    <?= Html::a('Si', ['eventos/finalizar-evento/' . $evento->nombreCortoEvento], ['class' => 'btn']) ?>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <!-- Button trigger modal -->

                                <!-- Modal -->
                                <div class="modal fade" id="publicar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Atención</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Está seguro de querer suspender su evento?</p>
                                                <p>No será visible en los lanzamientos de la plataforma, dejará de estar
                                                    disponible para las inscripciones y podrá seguir editando</p>
                                            </div>
                                            <div class="modal-footer">
                                                <?= Html::a('Si', ['eventos/suspender-evento/' . $evento->nombreCortoEvento], ['class' => 'btn']) ?>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    No
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    } elseif (Yii::$app->user->isGuest || !Yii::$app->user->isGuest) { // Para mostrar a los user invitados

                        echo '<div class="card-header bg_muni_azul_4 text-center">';
                        if ($verificacionSolicitud != false && !Yii::$app->user->can('Validador')) {
                            echo Html::a('Confirmar Solicitud <i class="material-icons align-middle">check_circle_outline</i>', ['confirmar-solicitud', 'token' => $verificacionSolicitud], [
                                'class' => 'btn',
                            ]);
                            echo Html::a('Denegar Solicitud <i class="material-icons align-middle">highlight_off</i>', ['denegar-solicitud', 'token' => $verificacionSolicitud], [
                                'class' => 'btn',
                            ]);
                        }
                        echo '</br></div>';
                    }
                    ?>


                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <?PHP
                                if ($esDueño && ($evento->fechaFinEvento > date("Y-m-d"))) {
                                    if ($evento->preInscripcion == 1) {
                                        echo '<div class="row mx-0 bg_muni_azul_45 card-header">';
                                        echo '<div class=" col-md-6 mx-0">' . Html::a('<i class="material-icons large align-middle link">question_answer</i><span class="text-white align-middle"> Crear Formulario de Preinscipción </span>', ['eventos/crear-formulario/' . $evento->nombreCortoEvento], ['class' => 'text-light', 'style' => 'text-decoration:none']) . ' </div>';
                                        echo '<div class=" col-md-6 mx-0">' . Html::a('<i class="material-icons large align-middle link">account_circle</i><span class="text-white align-middle"> Ver Respuestas a Formulario </span>', ['eventos/respuestas-formulario/' . $evento->nombreCortoEvento], ['class' => 'text-light', 'style' => 'text-decoration:none']) . ' </div>';
                                        echo '</div>';
                                    }
                                }
                                ?>
                                <?PHP if ($evento->fechaFinEvento <= date("Y-m-d") && $estadoEventoInscripcion == "yaAcreditado") {
                                    echo "<div class='alert alert-info text-center mb-4 mt-1' role='alert'>Usted ya ha asistido a este evento.</div>";
                                } ?>
                                <?= $logo ?>

                                <div class="padding_section">
                                    <span class="align-middle text_muni_azul_45 mr-2"><i class="material-icons align-middle">today</i> <?= date("d-m-Y", strtotime($evento->fechaInicioEvento)) ?></span>
                                    <?PHP
                                    if (!is_null($horaInicioEvento)) { ?>
                                        <span class="align-middle text_muni_azul_45"><i class="material-icons align-middle">access_time</i> <?= $horaInicioEvento . " - " . $horaFinEvento ?></span>
                                    <?PHP } ?>


                                    <br>
                                    <?php if ($esDueño || $esAdministrador) { ?>
                                        <div class="mt-4">
                                            <span class="align-middle">
                                                <?php
                                                echo Html::a('<i class="material-icons align-middle">email</i> Enviar un mail a los participantes', ['eventos/crear-email/' . $evento->nombreCortoEvento], ['style' => 'text-decoration:none;']);
                                                ?>
                                            </span>
                                        </div>

                                    <?php } ?>
                                    <br>
                                    <h2 class="text_muni_azul_5"><strong><?= $evento->nombreEvento ?></strong>
                                    </h2>
                                    <br>
                                    <h5 class="text-dark">Categoría: <?= $categoriaEvento ?></h5>
                                    <br>
                                    <!--<span>-->
                                    <?PHP
                                    if ($evento->imgFlyer != null) {
                                        echo Html::button('<i class="material-icons align-middle">file_download</i> Flyer', [

                                            'class' => 'btn text-muted',

                                            'id' => 'BtnModalId',

                                            'data-toggle' => 'modal',

                                            'data-target' => '#flyerModal',

                                        ]);
                                    }

                                    ?>
                                    <?php if ($esDueño) : ?>
                                        <?= Html::a('Visualizar QR', ['/evento/mostrar-qr-evento/', 'slug' => $evento->nombreCortoEvento], ['class' => 'btn ml-2 visualizarQR']); ?>
                                    <?php endif; ?>
                                    <!--</span>-->
                                </div>
                            </div>
                        </div>
                        <div class="row padding_section greyish_bg d-flex align-items-center">
                            <div class="col-sm-12 col-md-8">
                                <div class="cupos">
                                    <p class="text_muni_azul_45">CUPOS DISPONIBLES: <span class="font-weight-bolder"><?= $cupos ?></span> <?= " - "; ?> <?= $preInscripcion ?></p>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <div class="align-middle">
                                    <?php
                                    if ($evento->fechaFinEvento >= date("Y-m-d") && $evento->idEstadoEvento != 3) {
                                        switch ($estadoEventoInscripcion) {
                                            case "puedeInscripcion":
                                                if (/* !Yii::$app->user->isGuest && */$evento->req_incripcion == 1) {
                                                    echo Html::a('Inscribirse', ['inscripcion/preinscripcion', "slug" => $evento->nombreCortoEvento], ['class' => 'btn btn-primary btn-lg full_width']);
                                                }
                                                break;
                                            case "puedePreinscripcion":
                                                echo Html::a('Preinscribirse', ['inscripcion/preinscripcion', "slug" => $evento->nombreCortoEvento], ['class' => 'btn btn-primary btn-lg full_width']);
                                                break;
                                            case "sinCupos":
                                                echo Html::tag('p', 'Sin cupos.', ['class' => 'text-center', 'style' => 'font-size:0.8rem;margin:0px;']);
                                                //echo Html::label('Sin cupos');
                                                break;
                                            case "yaAcreditado":
                                                //echo Html::tag('p', 'Usted ya ha registrado su asistencia en este evento.', ['class' => 'text-center', 'style' => 'font-size:0.8rem;margin:0px;']);
                                                //echo Html::label("Usted ya se acreditó en este evento");
                                                break;
                                            case "inscriptoYEventoIniciado":
                                                echo Html::tag('p', 'El evento ya inició, pásela bien.', ['class' => 'text-center', 'style' => 'font-size:0.8rem;margin:0px;']);
                                                //echo Html::label("El evento ya inició, pasela bien");
                                                break;
                                            case "yaPreinscripto":
                                                echo Html::a('Anular Preinscripción', ['inscripcion/eliminar-inscripcion', "slug" => $evento->nombreCortoEvento], ['class' => 'btn btn-primary btn-lg full_width mb-3']);
                                                if ($cantidadPreguntas != 0) {
                                                    echo Html::a('Formulario de Preinscripción', ['eventos/responder-formulario/' . $evento->nombreCortoEvento], ['class' => 'btn btn-primary btn-lg full_width']);
                                                }
                                                break;
                                            case "yaInscripto":
                                                echo Html::a('Anular Inscripción', ['inscripcion/eliminar-inscripcion', "slug" => $evento->nombreCortoEvento], ['class' => 'btn btn-primary btn-lg full_width']);
                                                break;
                                            case "noInscriptoYFechaLimiteInscripcionPasada":
                                                echo Html::tag('p', 'No se puede inscribir, período de inscripciones cerrado.', ['class' => 'text-center', 'style' => 'font-size:0.8rem;margin:0px;']);
                                                //echo Html::label('No se puede inscribir, período de inscripciones cerrado');
                                                break;
                                            case "puedeAcreditarse":
                                                if ($inscripcion != null && $inscripcion->estado == 1) {
                                                    echo Html::a('Registrar Asistencia', ['acreditacion-evento/' . $evento->nombreCortoEvento], ['class' => 'btn btn-primary btn-lg full_width']);
                                                } else {
                                                    echo "";
                                                }
                                                break;
                                        }
                                    } else {
                                        if ($estadoEventoInscripcion == "puedeAcreditarse") {
                                            if ($inscripcion != null && $inscripcion->estado == 1) {
                                                echo Html::a('Acreditación', ['acreditacion-evento/' . $evento->nombreCortoEvento], ['class' => 'btn btn-primary btn-lg full_width']);
                                            } else {
                                                echo Html::tag('p', 'Usted ya ha registrado su asistencia.', ['class' => 'text-center', 'style' => 'margin:0px;']);
                                                //echo "<p class='text-center'>Usted ya está acreditado.</p>";
                                            }
                                        } else if ($estadoEventoInscripcion == "yaAcreditado") {
                                            echo Html::tag('p', 'Usted ya está acreditado.', ['class' => 'text-center', 'style' => 'margin:0px;']);
                                            //echo "<p class='text-center'>Usted ya está acreditado.</p>";
                                        } else {
                                            //echo Html::tag('p', 'El evento ya ha iniciado.', ['class' => 'text-center', 'style' => 'font-size:0.8rem;margin:0px;']);
                                            //echo "El evento ya ha iniciado";
                                        }
                                    }
                                    Modal::begin([
                                        'id' => 'modalEvento',
                                        'size' => 'modal-lg',
                                        'options' => ['tabindex' => ''],
                                    ]);
                                    Modal::end();

                                    Modal::begin([
                                        'id' => 'modalCertificado',
                                    ]);
                                    Modal::end();
                                    ?>
                                    <!-- Certificado -->
                                    <?php if ($evento->fechaFinEvento <= date("Y-m-d") and !Yii::$app->user->isGuest and $estadoEventoInscripcion == 'yaAcreditado') : ?>
                                        <?= Html::a('Certificado', ['certificado/index', 'id' => $evento->idEvento], ['class' => 'btn btn-primary btn-lg full_width viewCertification']); ?>
                                    <?php endif; ?>
                                    <!-- Validar evento - Usuario Validador-->
                                    <?php if ($estadoAval != 'no solicitado' && Yii::$app->user->can('Validador')) : ?>
                                        <?php if ($estadoAval->avalado != '0' && $estadoAval->avalado != '1') : ?>
                                            <?= Html::a('Denegar Aval <i class="material-icons align-middle">highlight_off</i>', ['denegar-solicitud', 'id' => $evento->idEvento], [
                                                'class' => 'btn m-2 float-right',
                                            ]); ?>
                                            <?= Html::a('Avalar Evento <i class="material-icons align-middle">check_circle_outline</i>', ['confirmar-solicitud', 'id' => $evento->idEvento], [
                                                'class' => 'btn m-2 float-right',
                                            ]); ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-8 padding_section">
                                <h4 class="text-uppercase pt-5">SOBRE ESTE EVENTO</h4>
                                <?= $evento->descripcionEvento ?>
                                <br>
                                <hr>
                                <h5>Organiza:</h5>
                                <?= $evento->secretariaEvento ?>

                            </div>
                            <div class="col-sm-12 col-md-4 padding_section white-text">
                                <ul class="list-group">
                                    <li class="list-group-item bg_muni_azul_5 text-white">
                                        <p>Fecha de Inicio: </p>
                                        <span class="font-weight-light text-light"><?= date("d-m-Y", strtotime($evento->fechaInicioEvento)) ?></span>
                                    </li>
                                    <li class="list-group-item bg_muni_azul_5 text-white">
                                        <p>Fecha de Finalización: </p>
                                        <span class="font-weight-light text-light"><?= date("d-m-Y", strtotime($evento->fechaFinEvento)) ?></span>
                                    </li>
                                    <li class="list-group-item bg_muni_azul_5 text-white">
                                        <p>Fecha Límite de Inscripción: </p>
                                        <span class="font-weight-light text-light"><?php
                                                                                    if ($evento->fechaLimiteInscripcion == null || $evento->fechaLimiteInscripcion == '1969-12-31') {
                                                                                        echo "Sin fecha límite"; ////
                                                                                    } else {
                                                                                        echo date("d-m-Y", strtotime($evento->fechaLimiteInscripcion));
                                                                                    } ?></span>
                                    </li>
                                    <li class="list-group-item bg_muni_azul_5 text-white">
                                        <p>Lugar: </p>
                                        <span class="font-weight-light text-light"><?= $evento->lugar ?></span>
                                    </li>
                                    <li class="list-group-item bg_muni_azul_5 text-white">
                                        <p>Modalidad: </p>
                                        <span class="font-weight-light text-light"><?= $modalidadEvento ?></span>
                                    </li>
                                    <li class="list-group-item bg_muni_azul_5 text-white">
                                        <p>Capacidad: </p>
                                        <span class="font-weight-light text-light"><?= ($evento->capacidad != null) ? $evento->capacidad : "Sin límite" ?></span>
                                    </li>
                                    <li class="list-group-item bg_muni_azul_5 text-white">
                                        <p>Fecha Publicación: </p>
                                        <span class="font-weight-light text-light"><?= date("d-m-Y", strtotime($fechaPublicacion)) ?></span>
                                    </li>
                                    <?php if ($esDueño || $esAdministrador) { ?>
                                        <li class="list-group-item bg_muni_azul_5 text-white">
                                            <span>
                                                <a class="btn btn-default full_width" href=<?= "/evento/lista-participantes?idEvento=$evento->idEvento&extension=csv" ?>>
                                                    <i class="material-icons align-middle">file_download</i>Listado de Participantes</a>
                                            </span>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="row padding_section grayish_bg">
                            <div class="col-sm-12">
                                <div class="d-flex">
                                    <h4 class="text-uppercase">AGENDA</h4>
                                    <?PHP
                                    if ($esDueño) {
                                        if ($evento->idEstadoEvento == 1 || $evento->idEstadoEvento == 4 || $evento->idEstadoEvento == 3) {
                                            echo Html::a('<i class="material-icons large">add</i>', ['/presentacion/cargar-presentacion/' . $evento->nombreCortoEvento], ['class' => 'agregarPresentacion link']);
                                        }
                                    } //url /presentacion/cargar-presentacion/
                                    ?>

                                </div>

                                <div class="table table-responsive d-none d-md-block">
                                    <?=
                                    GridView::widget([
                                        'dataProvider' => $presentacionDataProvider,
                                        'summary' => '',
                                        //                        'filterModel' => $searchModel,
                                        'options' => ['style' => 'width:100%;'],
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],
                                            //'idPresentacion',
                                            //'tituloPresentacion',
                                            [
                                                'attribute' => 'Título',
                                                'format' => 'raw',
                                                'value' => function ($dataProvider) {
                                                    //return $dataProvider->tituloPresentacion . ' <br/><small>' . Html::a('(Más información)', [Url::to(['presentacion/view', 'presentacion' => $dataProvider->idPresentacion])], ['class' => 'verPresentacion']) . '</small>'; //<a href="' . Url::to(['presentacion/view', 'presentacion' => $dataProvider->idPresentacion, 'class' => 'verPresentacion']) . '">(Más información)</a>                                            },
                                                    return $dataProvider->tituloPresentacion . ' <br/><small>' . Html::a('(Más información)', ['/presentacion/view', 'presentacion' => $dataProvider->idPresentacion], ['class' => 'verPresentacion']) . '</small>'; //<a href="' . Url::to(['presentacion/view', 'presentacion' => $dataProvider->idPresentacion, 'class' => 'verPresentacion']) . '">(Más información)</a>
                                                },
                                                'headerOptions' => ['style' => 'width:30%;text-align:center;'],
                                            ],
                                            //'diaPresentacion',
                                            [
                                                'attribute' => 'Día',
                                                'value' => function ($dataProvider) {
                                                    $fechaConBarras = date('d/m/Y', strtotime($dataProvider->diaPresentacion));
                                                    return $fechaConBarras;
                                                },
                                                'headerOptions' => ['style' => 'text-align:center;'],
                                                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                                            ],
                                            //'horaInicioPresentacion',
                                            [
                                                'attribute' => 'Inicio',
                                                'value' => function ($dataProvider) {
                                                    $horaSinSegundos = date('H:i', strtotime($dataProvider->horaInicioPresentacion));
                                                    return $horaSinSegundos;
                                                },
                                                'headerOptions' => ['style' => 'text-align:center;'],
                                                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                                            ],
                                            //'linkARecursos',
                                            [
                                                'attribute' => 'Recursos',
                                                'format' => 'raw',
                                                'value' => function ($dataProvider) {
                                                    //HACER IF
                                                    if ($dataProvider->linkARecursos == null || $dataProvider->linkARecursos == "") {
                                                        $retorno = 'No hay recursos para mostrar';
                                                    } else {
                                                        $retorno = '<a target="_blank" href="' . $dataProvider->linkARecursos . '"><i class="material-icons">attachment</i></a>';
                                                    }
                                                    return $retorno;
                                                },
                                                'headerOptions' => ['style' => 'text-align:center;'],
                                                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                                            ],
                                            [
                                                'attribute' => 'Expositores',
                                                'format' => 'raw',
                                                'value' => function ($dataProvider) {

                                                    if (count($dataProvider->presentacionExpositors) == 0) {
                                                        $string = "No hay expositores";

                                                        if (!Yii::$app->user->isGuest && $dataProvider->idEvento0->idUsuario == Yii::$app->user->identity->idUsuario) {
                                                            $string .= ' ' . Html::a('<i class="material-icons">person_add</i>', ['/evento/cargar-expositor/' . $dataProvider->idPresentacion], ['class' => 'cargarExpositores']);
                                                        }
                                                    } else {
                                                        $string = "";
                                                        if (!Yii::$app->user->isGuest && $dataProvider->idEvento0->idUsuario == Yii::$app->user->identity->idUsuario) {
                                                            $string = Html::a('<i class="material-icons">person_add</i>', ['/evento/cargar-expositor/' . $dataProvider->idPresentacion], ['class' => 'cargarExpositores']);
                                                        }
                                                        $string .= '&nbsp;&nbsp;&nbsp;&nbsp;' . Html::a('<i class="material-icons">remove_red_eye</i>', ['/presentacion-expositor/ver-expositores/' . $dataProvider->idPresentacion], ['class' => 'verExpositores']);
                                                    }
                                                    return $string;
                                                },
                                                'headerOptions' => ['style' => 'text-align:center;'],
                                                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                                            ],
                                            //'expositores',

                                            [
                                                'class' => 'yii\grid\ActionColumn',
                                                //genera una url para cada boton de accion
                                                'urlCreator' => function ($action, $model, $key, $index) {
                                                    if ($action == "update") {
                                                        return Url::to(['/presentacion/update', 'presentacion' => $key]);
                                                    }
                                                    if ($action == "delete") {
                                                        return Url::to(['/presentacion/borrar', 'presentacion' => $key]);
                                                    }
                                                },
                                                //describe los botones de accion
                                                'buttons' => [
                                                    'view' => function ($url, $model) {
                                                        //                                                    return Html::a('<img src="' . Yii::getAlias('@web/icons/pencil.svg') . '" alt="Editar" width="20" height="20" title="Editar" role="img">', $url, ['class' => 'btn editarPresentacion']);
                                                        return false;
                                                    },
                                                    'update' => function ($url, $model) {
                                                        //                                                    return Html::a('<img src="' . Yii::getAlias('@web/icons/pencil.svg') . '" alt="Editar" width="20" height="20" title="Editar" role="img">', $url, ['class' => 'btn editarPresentacion']);
                                                        return Html::a('<i class="material-icons">edit</i>', $url, ['class' => 'btn btn_icon editarPresentacion']);
                                                    },
                                                    'delete' => function ($url, $model) {
                                                        return Html::a('<i class="material-icons">remove_circle_outline</i>', $url, ['class' => 'btn btn_icon borrarPresentacion']);
                                                    }
                                                ],
                                                'header' => 'Acciones',
                                                'headerOptions' => ['style' => 'text-align:center;'],
                                                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                                                'visible' => $esDueño && ($evento->idEstadoEvento == 1 || $evento->idEstadoEvento == 4 || $evento->idEstadoEvento == 3),
                                            ],
                                            //
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <div class="tabla-celulares d-md-none d-block m-auto">
                                    <?php
                                    $celularPresentaciones = $evento->presentacions;
                                    foreach ($celularPresentaciones as $unaPresentacion) {
                                    ?>
                                        <div class="card border my-2">
                                            <div class="card-header dark_bg text-light rounded">
                                                <div class="col-12 d-flex justify-content-center align-items-center">
                                                    <div class="col-12 d-flex align-items-center"><?= $unaPresentacion->tituloPresentacion; ?>
                                                        <?= '&nbsp;&nbsp;&nbsp;&nbsp;' . Html::a('<i class="material-icons">info_outline</i>', ['/presentacion/view', 'presentacion' => $unaPresentacion->idPresentacion], ['class' => 'verPresentacion']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <!--<div class="col-6 d-flex align-items-center">-->
                                                    <tr>
                                                        <td class="align-middle">
                                                            <span class="d-flex justify-content-center align-items-center"><i class="material-icons">today</i>&nbsp;&nbsp;<?= date('d/m/Y', strtotime($unaPresentacion->diaPresentacion)); ?><span>
                                                        </td>
                                                        <!--</div>-->

                                                        <!--<div class="col-6 d-flex align-items-center">-->
                                                        <td class="align-middle">
                                                            <span class="d-flex justify-content-center align-items-center"><i class="material-icons">access_time</i>&nbsp;&nbsp;<?= date('H:i', strtotime($unaPresentacion->horaInicioPresentacion)); ?></span>
                                                        </td>
                                                    </tr>
                                                    <!--</div>-->

                                                    <!--<div class="col-12">-->
                                                    <?php
                                                    if ($unaPresentacion->linkARecursos == null || $unaPresentacion->linkARecursos == "") {
                                                        $recursos = ' - ';
                                                    } else {
                                                        $recursos = '<a class="btn btn_icon" style="background:#007bff;" target="_blank" href="' . $unaPresentacion->linkARecursos . '"><i class="material-icons">attachment</i></a>';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td class="align-middle">Recursos:</td>
                                                        <td class="align-middle text-center"><?= $recursos; ?></td>
                                                    </tr>

                                                    <!--</div>-->
                                                    <!--<div class="col-12">-->
                                                    <?php
                                                    $verExpositores = " - ";
                                                    if (count($unaPresentacion->presentacionExpositors) == 0) {
                                                        if (!Yii::$app->user->isGuest && $unaPresentacion->idEvento0->idUsuario == Yii::$app->user->identity->idUsuario) {
                                                            $cargarExpositores = Html::a('<i class="material-icons">person_add</i>', ['/evento/cargar-expositor/' . $unaPresentacion->idPresentacion], ['class' => 'btn btn_icon cargarExpositores', 'style' => 'background:#007bff;']);
                                                        }
                                                    } else {
                                                        if (!Yii::$app->user->isGuest && $unaPresentacion->idEvento0->idUsuario == Yii::$app->user->identity->idUsuario) {
                                                            $cargarExpositores = Html::a('<i class="material-icons">person_add</i>', ['/evento/cargar-expositor/' . $unaPresentacion->idPresentacion], ['class' => 'btn btn_icon cargarExpositores', 'style' => 'background:#007bff;']);
                                                        }
                                                        $verExpositores = Html::a('<i class="material-icons">remove_red_eye</i>', ['/presentacion-expositor/ver-expositores/' . $unaPresentacion->idPresentacion], ['class' => 'btn btn_icon verExpositores', 'style' => 'background:#007bff;']);
                                                    }
                                                    ?>
                                                    <?php
                                                    $rowspanExpositor = "";
                                                    if (!Yii::$app->user->isGuest && $unaPresentacion->idEvento0->idUsuario == Yii::$app->user->identity->idUsuario) {
                                                        $rowspanExpositor = 'rowspan="2"';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td <?= $rowspanExpositor ?> class="align-middle">Expositores:
                                                        </td>
                                                        <td class="align-middle text-center"><?= $verExpositores; ?></td>
                                                        <?php if (!Yii::$app->user->isGuest && $unaPresentacion->idEvento0->idUsuario == Yii::$app->user->identity->idUsuario) { ?>
                                                    <tr>
                                                        <td class="align-middle text-center"><?= $cargarExpositores; ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tr>

                                                <!--</div>-->
                                                <!--<div class="col-6">-->
                                                <?php
                                                //$acciones = "Acciones: &nbsp;&nbsp;&nbsp;&nbsp;";
                                                ?>
                                                <!--</div>-->
                                                <!--<div class="col-6">-->
                                                <?php if (!Yii::$app->user->isGuest && $unaPresentacion->idEvento0->idUsuario == Yii::$app->user->identity->idUsuario) {
                                                    $accionEditar = Html::a('<i class="material-icons">edit</i>', Url::to(['/presentacion/update', 'presentacion' => $unaPresentacion->idPresentacion]), ['class' => 'btn btn_icon editarPresentacion']);
                                                    $accionBorrar = Html::a('<i class="material-icons text-white">remove_circle_outline</i>', Url::to(['/presentacion/borrar', 'presentacion' => $unaPresentacion->idPresentacion]), ['class' => 'btn btn_icon borrarPresentacion']);
                                                ?>
                                                    <tr>
                                                        <td rowspan="2" class="align-middle">Acciones:</td>
                                                        <td class="align-middle text-center"><?= $accionEditar; ?></td>
                                                    <tr>
                                                        <td class="align-middle text-center"><?= $accionBorrar; ?></td>
                                                    </tr>
                                                    </tr>
                                                <?php } ?>

                                                <!--</div>-->
                                                </table>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="flyerModal" tabindex="-1" role="dialog" aria-labelledby="flyerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="flyerModalLabel">Flyer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img class="full_width" src='<?= $flyer ?>'>
            </div>
            <div class="modal-footer">
                <a href="<?= $flyer ?>" class="btn btn-secondary" download>Bajar</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<?php
Modal::begin([
    'id' => 'QRModal',
    'size' => 'modal-lg',
]);
Modal::end();
?>
</div>