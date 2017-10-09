<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Categories */

$this->title = 'Actualitzar Categoria';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Actualitzar';
?>
<div class="categories-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
