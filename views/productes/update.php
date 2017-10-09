<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Productes */

$this->title = 'Actualitzar producte';
$this->params['breadcrumbs'][] = ['label' => 'Productes', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Actualitzar prodcute';
?>
<div class="productes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
