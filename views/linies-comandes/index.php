<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Linies Comandes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linies-comandes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Linies Comandes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'comanda_fk',
            'producte_fk',
            'quantitat_solicitada',
            'quantitat_servida',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
