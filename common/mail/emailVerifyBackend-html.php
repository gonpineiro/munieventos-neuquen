<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

//$verifyLink = Yii::$app->urlManager->createAbsoluteUrl([Yii::getAlias("@frontend").'/site/verify-email', 'token' => $user->verification_token]);
//$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(Url::to([Yii::getAlias("@frontend").'/site/verify-email', 'token' => $user->verification_token]));
//$verifyLink = Yii::$app->urlManager->createUrl([Yii::getAlias("@frontend").'/site/verify-email', 'token' => $user->verification_token]);
//$verifyLink = Yii::$app->urlManagerToFrontEnd->createAbsoluteUrl(['../../../frontend/site/verify-email', 'token' => $user->verification_token]);
//$verifyLink = Html::a('Hola jaja', Url::to());
//Yii::$app->urlManager->
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
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

        .link-button:hover {
            color: #fff;
            background-color: #204d74;
            border-color: #122b40;
        }
    </style>

    <div class="verify-email" style="
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

                    <p> Ya est??s registrado en <?= Html::encode(Yii::$app->name) ?>. </p>

                    <div style="margin-top: 15px;">
                        <small>(Correo Generado Autom??ticamente)</small>
                    </div>
    </div>


</body>

</html>