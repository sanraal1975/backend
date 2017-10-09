<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Comandes */

$this->title = 'Create Comandes';
$this->params['breadcrumbs'][] = ['label' => 'Comandes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comandes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
