<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Productes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="productes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'categoria_fk')->dropDownList($categories) ?>

    <?= $form->field($model, 'descripcio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stock')->textInput() ?>

    <?= $form->field($model, 'pendents')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
