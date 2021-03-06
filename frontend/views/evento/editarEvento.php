<?php

use dosamigos\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

use frontend\models\CategoriaEvento;
use frontend\models\ModalidadEvento;


/* @var $this yii\web\View */
/* @var $model frontend\models\Evento */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Editar Evento - " . $model->nombreCortoEvento;
?>
<div class="dark_light_bg">
    <div class="container padding_hero">
        <div class="card shadow">
            <div class="card-header bg_muni_azul_4">
                <h2 class="text-center text-white">Editar Evento</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <div class="evento-form">
                            <p class="text-center">Complete los siguientes campos</p>

                            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                            <!-- Oculto, se carga con el id del usuario logueado que esta crendo el evento (usuario organizador) -->
                            <?= $form->field($model, 'idUsuario')->hiddenInput(['value' => Yii::$app->user->identity->idUsuario])->label(false); ?>

                            <?= $form->field($model, 'nombreEvento')->textInput(['maxlength' => true, 'placeholder' => 'Ingrese nombre'])->label(false) ?>

                            <label for="evento-nombrecortoevento"> Nombre corto del evento: * </label>
                            <div class="row">
                                <div class="col-4 form-advice">
                                    <span class="m-auto"> Opciones automaticas: </span>
                                </div>
                                <div class="nombresCortos" id="automaticSlug">
                                </div>
                                <br>
                                <div class="col-12 mt-2 nombresCortos">
                                    <!--<input type="radio" id="otro" name="shortName" value=""> <label for="otro">Otro: </label>-->
                                    <?= $form->field($model, 'nombreCortoEvento')->textInput([
                                        'maxlength' => true, 'placeholder' => 'Ingrese  nombre corto',
                                        'data-title' => 'Requisitos',
                                        'data-toggle' => 'popover',
                                        'data-content' => 'Solo puede tener n??meros y letras, sin caracteres especiales y los espacios deben ser guiones. Ejemplo test-evento.',
                                    ])->label(false) ?>
                                </div>
                            </div>

                            <?php
                            //minimize ckedit on escape
                            $this->registerJs(
                                'CKEDITOR.on("instanceCreated", function (e) {
                                        e.editor.on("contentDom", function () {
                                            e.editor.document.on("keydown", function (evto) {
                                                if (evto.data.$.keyCode === 27 || evto.data.$.key === "Escape") {
                                                    e.editor.execCommand("maximize");
                                                }
                                            }
                                        );
                                    });
                                    });'
                            );
                            ?>

                            <?= $form->field($model, 'descripcionEvento')->widget(CKEditor::className(), [
                                "options" => ['rows' => '8'],
                                "preset" => "custom",
                                "clientOptions" => [
                                    'extraPlugins' => 'justify,font',
                                    'toolbarGroups' => [
                                        ['name' => 'clipboard', 'groups' => ['clipboard', 'undo']],
                                        ['name' => 'editing', 'groups' => ['find', 'selection', 'spellchecker']],
                                        ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
                                        ['name' => 'colors'],
                                        ['name' => 'links'],
                                        ['name' => 'tools'],
                                        '/',
                                        ['name' => 'paragraph', 'groups' => ['list', 'indent', 'blocks', 'align', 'bidi']],
                                        ['name' => 'styles', 'groups' => ['Styles', 'Format', 'Font', 'FontSize']],
                                        ['name' => 'font',],
                                        ['name' => 'styles'],
                                        ['name' => 'maximize'],


                                    ],
                                    'removeButtons' => 'Subscript,Superscript,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe',
                                    'removePlugins' => 'elementspath',
                                    'resize_enabled' => true
                                ],
                            ])->label('Descripci??n *') ?>

                            <?= $form->field($model, 'lugar')->textInput(['placeholder' => 'Ingrese lugar'], ['maxlength' => true])->label('Lugar *') ?>

                            <!-- select categoria -->
                            <?= $form->field($model, 'idCategoriaEvento')->dropdownList($categoriasEventos, ['prompt' => 'Seleccione una categor??a'])->label('Categor??a *'); ?>

                            <!-- select modalidad -->
                            <?= $form->field($model, 'idModalidadEvento')->dropdownList($modalidadEvento, ['prompt' => 'Selecciona una modalidad'])->label('Modalidad *'); ?>

                            <?= $form->field($model, 'secretariaEvento')->dropdownList($secretariaEvento, ['prompt' => $model->secretariaEvento])->label('Secretar??as / Uniades de Gesti??n *'); ?>

                            <!-- input logo -->
                            <?= $form->field($modelLogo, 'imageLogo')->fileInput()->label('Ingrese logo [solo formato png, jpg y jpeg]') ?>
                            <button type="button" id="quitarLogo" class="btn btn-sm btn-outline">Quitar</button>
                            <br>
                            <br>
                            <!-- input flyer -->
                            <?= $form->field($modelFlyer, 'imageFlyer')->fileInput()->label('Ingrese flyer [solo formato png,  jpg y jpeg]') ?>
                            <button type="button" id="quitarFlyer" class="btn btn-sm btn-outline">Quitar</button>
                            <br>
                            <br>
                            <?= $form->field($model, 'fechaInicioEvento')->input('date', ['style' => 'width: auto'])->label('Fecha Inicio *') ?>

                            <?= $form->field($model, 'fechaFinEvento')->input('date', ['style' => 'width: auto'])->label('Fecha Fin *') ?>
                            <div class="form-group">
                                <label>??Posee l??mite de participantes?</label><br>

                                <div role="radiogroup" aria-required="true">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="espectadores-no" name="posee-espectadores" value="-1" checked required>
                                        <label class="custom-control-label" for="espectadores-no">No</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="espectadores-si" name="posee-espectadores" value="2">
                                        <label class="custom-control-label" for="espectadores-si">Si</label><br>
                                    </div>
                                </div>
                            </div>

                            <div id="mostrarCapacidad">
                                <?= $form->field($model, 'capacidad')->input('number', ['min' => 1, 'max' => 10000])->label('Ingrese n??mero de participantes *') ?>
                            </div>
                            <div id="inscripcion">
                                <?= $form->field($model, 'req_incripcion')->radioList([0 => 'No', 1 => 'Si'])->label('??Requiere inscripci??n? *') ?>
                            </div>
                            <!-- select requiere preInscripcion -->
                            <div id="preInscricion" style="display: none;">
                                <?= $form->field($model, 'preInscripcion')->radioList([0 => 'No', 1 => 'Si'])->label('??Requiere preinscripci??n? * Necesita un l??mite de participantes') ?>

                            </div>

                            <!-- calendar -->
                            <div id="fechaLimite">
                                <?= $form->field($model, 'fechaLimiteInscripcion')->input('date', ['style' => 'width:auto'])->label('Fecha l??mite de preinscripci??n *') ?>
                            </div>


                            <?= $form->field($model, 'codigoAcreditacion')->textInput(['placeholder' => 'Ingrese c??digo de acreditaci??n'], ['maxlength' => true]) ?>


                            <p class="font-italic">
                                Los campos marcados con (*) son obligatorios.
                            <p>
                            <div class="form-group">
                                <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
                                <?= Html::a('Cancelar', ['eventos/ver-evento/' . $model->nombreCortoEvento], ['class' => 'btn btn-primary']); ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>