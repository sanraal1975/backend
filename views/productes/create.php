<?php

use yii\helpers\Html;
use app\components\Debug;

/* @var $this yii\web\View */
/* @var $model app\models\Productes */

$this->title = 'Create Productes';
$this->params['breadcrumbs'][] = ['label' => 'Productes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="productes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
