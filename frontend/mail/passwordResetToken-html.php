<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

if (preg_match('/backend/i', Yii::$app->request->referrer)) {
    $resetLink = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
} else {
    $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
}
?>
<style>
    .link-button {
        border: 1px solid #ccc;
        padding: 6px 12px;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        cursor: pointer;
        background-image: none;
        border: 1px solid transparent;
        border-radius: 4px;
        text-decoration: none;

        color: black;
        background-color: #335992;
        border-color: #2e6da4;
    }
</style>

<div class="password-reset" style="
        text-align: center;
        padding-top: 30px;
        padding-bottom: 30px;
        padding-right: 5px;
        padding-left: 5px;
        border: 3px;
        background-color: #266AAD;
        color: white;
        border-color: #266AAD">

    <!-- <img src="images/juntar-logo/svg/juntar-logo-w.svg" alt="Logo Juntar" height="200px" width="300px"> -->
    <!-- <img src="<?php //Yii::$app->getAlias('@frontend/web/images/juntar-logo/png/juntar-icon-b.png') 
                    ?>" alt="Logo Juntar"> -->

    <p><b> Hola <?= Html::encode($user->nombre . " " . $user->apellido) ?>.<b>
                <p><br>

                <p> Hemos recibido una solicitud para restablecer tu contraseña en la
                    plataforma <?= Html::encode(Yii::$app->name) ?>. </p>
                <p> Si no pediste el cambio de contraseña y crees que fue un error, por favor, ignora este correo y contactanos
                    lo antes posible. </p>

                <p style="margin-bottom: 50px"> Para restablecer tu contraseña, clickea sobre el botón "Restablecer
                    contraseña": </p>

                <!-- Botón -->
                <p style="margin-top: 15px;"><a href="<?= Html::encode($resetLink) ?>" style="border: 1px solid #ccc;
            margin-top: 20px;
            padding: 12px 12px;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 0.3rem;
            text-decoration: none;

            color: black;
            background-color: white;
            border-color: white;"> Restablecer contraseña </a></p>


                <div style="margin-top: 15px;">
                    <small>(Correo Generado Automáticamente)</small>
                </div>
</div>