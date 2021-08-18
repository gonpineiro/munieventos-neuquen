<?php

use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\YiiAsset;

?>
<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Evento */

$this->title = "Acreditación";
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="acreditacion-view container">

    <div class="row">
        <div class="col-md-6 col-sm-12 m-auto">
            <?php $form = ActiveForm::begin(['id' => 'acreditacion-form']); ?>
            <?= $form->field($model, 'codigoAcreditacion')->textInput(['autofocus' => true])->label("Ingrese el código para registrar su asistencia: ") ?>
            <div class="form-group">
                <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                <a href="#" class="btn" onclick="history.back()">Volver Atrás</a>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>