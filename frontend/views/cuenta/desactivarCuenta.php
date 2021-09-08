<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Jugador */

$this->title = 'Desactivar Cuenta ';

$this->params['breadcrumbs'][] = 'Actualizar información';
?>
<div class="profile-update container text-center">

    <h1 class="text_muni_azul_5 mb-5"> Desactivar Mi Cuenta </h1>
    <p> ¿Está seguro que desea desactivar su cuenta?</p>
    <p>Esta opción no le permitirá acceder al sitio hasta que pida un <strong>email de activación</strong>. </p>

    <div class="row mx-auto mt-5">
        <div class="profileForm w-100">
            <?php $form = ActiveForm::begin(); ?>
            <div class="form-group">
                <?= Html::submitButton('Desactivar Cuenta', ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>