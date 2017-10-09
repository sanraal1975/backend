<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LiniesComandes */

$this->title = 'Modificar Linia de Comanda';
$this->params['breadcrumbs'][] = ['label' => 'Comandes', 'url' => ['/comandes/index']];
$this->params['breadcrumbs'][] = ['label' => 'Comanda ', 'url' => ['/comandes/view', 'id' => $model->comanda_fk]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="linies-comandes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'productes' => $productes,
    ]) ?>

</div>
