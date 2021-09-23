<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model LoginForm */

use common\models\LoginForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Iniciar sesión';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login container">
    <h1 class="text-center mb-2"><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-5 m-auto">
            <form action="">
                <div class="form-group">
                    <label for="dniOrEmail">DNI o Correo Electrónico</label>
                    <input type="text" class="form-control" id="dniOrEmail">
                </div>
                <div class="form-group">
                    <label for="password">Clave</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <button type="submit" class="btn btn-primary">Ingresar</button>
            </form>
        </div>
    </div>
</div>