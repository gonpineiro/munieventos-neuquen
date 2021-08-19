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
        $daysMessage = "el dìa " . $initialDay->format("d");
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

    <div class="container">
        <div class="centring logos">
            <?php
            $pathLogo = "images/logo-14.svg";
            if ($isOficial) {
                echo
                '<img id="" style="min-height:500px!important;padding-top:4rem;" class="" src="' . $pathLogo . '">';
            } else {
                echo '<img id="" style="min-height:500px!important;padding-top:4rem;" class="" src="' . $pathLogo . '">';
            }
            ?>
        </div>
        <div class="head">
            <h3 class="centring" style="padding-top: 4rem;color: #335992;font-size:3rem;margin:0px;">Certificado</p>
        </div>
        <div class="body">
            <p class="centring" style="color:#266aad;">Se certifica que <b><?= $user->apellido . ", " . $user->nombre ?></b>, DNI Nº
                <b><?= $user->dni ?></b>
            </p>
            <p class="centring" style="color:#266aad;"> <?= $type . " " . $category ?> </p>
            <p class="centring event"><b>"<?= $event[0]['nombreEvento'] ?>"</b></p>
            <p class="centring" style="color:#266aad;"> Realizado <?= $daysMessage ?> de <?= $months[$numberMonth] ?>
                del <?= date("Y", strtotime($event[0]['fechaInicioEvento'])) ?>,
                <?php if ($certificateType != 'expositor') : ?>
                    <?php if ($hours->format("H") != '00') : ?>
                        con una duración de <?= $hours->format("H:i") ?> Hs.
                    <?php endif; ?>
                    <?php endif; ?>dictado en:</p></br>
            <p class="centring" style="color:#266aad;"><b><?= $event[0]['lugar'] ?></b>.</p>
            <p class="centring" style="color:#266aad;">Neuquén, <?= date('d/m/Y') ?>.</p>
        </div>
    </div>
</body>

</html>