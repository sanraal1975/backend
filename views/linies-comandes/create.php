<?php

use yii\helpers\Html;
use app\components\Debug;


/* @var $this yii\web\View */
/* @var $model app\models\LiniesComandes */

$this->title = 'Create Linies Comandes';
$this->params['breadcrumbs'][] = ['label' => 'Linies Comandes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linies-comandes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'productes' => $productes,
    ]) ?>

</div>
