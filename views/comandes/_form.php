<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Comandes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comandes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'client_fk')->textInput(); ?>

    <?= $form->field($model, 'data')->textInput() ?>

    <?= $form->field($model, 'estat_fk')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
