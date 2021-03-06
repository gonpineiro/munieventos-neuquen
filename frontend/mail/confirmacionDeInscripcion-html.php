<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */


$nombreEvento = $evento->nombreEvento;
$lugarEvento = $evento->lugar;
$inicio = date('d-m-Y', strtotime($evento->fechaInicioEvento));
$fin = date('d-m-Y', strtotime($evento->fechaFinEvento));
if (!is_null($evento->horaInicioEvento) && !is_null($evento->horaFinEvento) && !empty($evento->horaInicioEvento) && !empty($evento->horaFinEvento)) {
    $horarios = " desde " . $evento->horaInicioEvento . " hasta " . $evento->horaFinEvento;
} else {
    $horarios = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>


    <div class="verify-email" style="
            text-align: center;
            padding-top: 30px;
            padding-bottom: 30px;
            padding-right: 5px;
            padding-left:5px;">

        <!-- <img src="images/juntar-logo/svg/juntar-logo-w.svg" alt="Logo Juntar" height="200px" width="300px"> -->
        <!-- <img src="<?php //Yii::$app->getAlias('@frontend/web/images/juntar-logo/png/juntar-icon-b.png') 
                        ?>" alt="Logo Juntar"> -->


        <p>¡Gracias por Inscribirse al evento <b><?= $evento->nombreEvento ?></b>!</p>
        <p>Te recordamos que la fecha de inicio es <?= $inicio . " " . $horarios ?> y se realizará en <?= $lugarEvento ?>.</p>
        <p>El evento finaliza el <?= $fin ?></p>


        <div style="margin-top: 45px;">
            <small><i>(Correo Generado Automáticamente)<i></small>
        </div>
    </div>


</body>

</html>