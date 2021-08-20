<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>


</head>

<body>
    <?php
    //Obtención de los datos.
    $hours = new DateTime("0000-00-00 00:00:00");
    if (!is_null($presentations['collections'])) {
        foreach ($presentations['collections'] as $presentation) {
            $hoursInit = new DateTime($presentation['horaInicioPresentacion']);
            $hoursEnd = new DateTime($presentation['horaFinPresentacion']);
            $hoursDiff = $hoursInit->diff($hoursEnd);
            $hours->add($hoursDiff);
        }
    }

    $initialDay = new DateTime($event[0]->fechaInicioEvento);
    $latestDay = new DateTime($event[0]->fechaFinEvento);

    if ($initialDay <> $latestDay) {

        $intervale = $latestDay->diff($initialDay);
        if ($intervale->days == 1) {
            $daysMessage = "los días " . $initialDay->format("d") . " y " . $latestDay->format("d");
        } else {
            $daysMessage = "desde el " . $initialDay->format("d") . " hasta el " . $latestDay->format("d");
        }
    } else {
        $daysMessage = "el día " . $initialDay->format("d");
    }

    //Arrays Auxiliar.
    $months = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $numberMonth = date("m", strtotime($event[0]->fechaInicioEvento)) - 1;

    if ($category->descripcionCategoria != 'Otra') {
        $category = $category->descripcionCategoria;
    } else {
        $category = 'evento';
    }
    switch ($certificateType) {
        case 'organizador':
            $type = "Participó como Organizador del ";
            break;
        case 'expositor':
            $type = "Participó como Expositor de <b>\"" . $presentation->tituloPresentacion . "\"</b> en el";
            break;
        case 'asistencia':
            $type = "Asistió al ";
            break;
    }
    ?>

    <div class="centring logos">
        <?php

        $pathLogo = substr($event[0]['imgLogo'], 1);
        if (file_exists($pathLogo)) {
            $banner = '<img class="full_width" src="' . $pathLogo . '">';
        }
        echo $banner;
        ?>
    </div>
    <div class="head">
        <h3 class="centring" style="padding-top: 3rem;font-size:3rem;margin:0px;">Certificado de Asistencia</p>
    </div>
    <div class="body">
        <p class="centring">Se certifica que <b style="font-size: 2rem;"><?= $user->apellido . ", " . $user->nombre ?></b>
        </p>
        <p class="centring">DNI Nº
            <b><?= $user->dni ?></b>
        </p>
        <p>
            </h5>
        <p class="centring"> <?= $type . " " . $category ?> </p>
        <p class="centring event"><b>"<?= $event[0]['nombreEvento'] ?>"</b></p>
        <p class="centring"> Realizado por <?= $event[0]['secretariaEvento']; ?>, <br> <?= $daysMessage ?> de <?= $months[$numberMonth] ?>
            del <?= date("Y", strtotime($event[0]['fechaInicioEvento'])) ?>,
            <?php if ($certificateType != 'expositor') : ?>
                <?php if ($hours->format("H") != '00') : ?>
                    con una duración de <?= $hours->format("H:i") ?> Hs.
                <?php endif; ?>
                <?php endif; ?>dictado en:</p></br>
        <p class="centring"><b><?= $event[0]['lugar'] ?></b>, Neuquén, <?= date('d/m/Y') ?>.</p>
        <p class="centring"></p>
    </div>
    </div>
</body>

</html>