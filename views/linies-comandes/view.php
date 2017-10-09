<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LiniesComandes */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comandes', 'url' => ['/comandes/index']];
$this->params['breadcrumbs'][] = ['label' => 'Comanda ', 'url' => ['/comandes/view', 'id' => $model->comanda_fk]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linies-comandes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'comanda_fk',
            'producte_fk',
            'quantitat_solicitada',
            'quantitat_servida',
        ],
    ]) ?>

</div>
