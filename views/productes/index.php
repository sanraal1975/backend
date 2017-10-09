<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\Debug;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Productes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="productes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Productes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute'=>'categoria_fk', 'label'=>'Categoria'],
            'descripcio',
            'stock',
            'pendents',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
