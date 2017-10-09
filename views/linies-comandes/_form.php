<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LiniesComandes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="linies-comandes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comanda_fk')->textInput(['readonly' => !$model->isNewRecord]) ?>

    <?= $form->field($model, 'producte_fk')->dropDownList($productes,['disabled' => !$model->isNewRecord, 'options' => [$model->producte_id => ['selected' => TRUE]]]) ?>

    <?= $form->field($model, 'quantitat_solicitada')->textInput(['readonly' => !$model->isNewRecord]) ?>

    <?= $form->field($model, 'quantitat_servida')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
