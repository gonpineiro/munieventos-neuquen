<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Iniciar sesión';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login container">
    <div class="row">
        <div class="col-12 col-md-8 mx-auto">
            <div class="mx-auto pb-4" style="width:250px">
                <?= Html::img('@web/images/logo-03.svg', ['style' => 'width:250px']) ?>
            </div>
            <h4 class="text-center pb-3 text_muni_azul_5">Iniciar Sesión</h4>
            <form action="">
                <div class="form-group col-12 col-md-6 mx-auto">
                    <label for="dniOrEmail">DNI o Correo Electrónico</label>
                    <input type="text" class="form-control" id="dniOrEmail">
                </div>
                <div class="form-group col-12 col-md-6 mx-auto">
                    <label for="password">Clave</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <div class="form-group col-12 col-md-6 mx-auto">
                    <button type="submit" class="btn btn-primary login-btn">Ingresar</button>
                    <div class="pt-3"> <a href="https://weblogin.muninqn.gov.ar">Quiero registrarme</a>

                    </div>

            </form>
        </div>

    </div>

</div>
</div>