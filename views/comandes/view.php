<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\components\Debug;

/* @var $this yii\web\View */
/* @var $model app\models\Comandes */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comandes', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Veure Comanda';
?>
<div class="comandes-view">

    <h1><?= Html::encode("Comanda") ?></h1>

    <p>
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
            'client_fk',
            'data',
            'estat_fk',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $linies,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'producte_fk',
            'quantitat_solicitada',
            'quantitat_servida',

            ['class' => 'yii\grid\ActionColumn', 
                'template' => '{update}',
                'buttons' => [
                    'update' => function($model,$key,$index){
                        return HTML::a('<span class="glyphicon glyphicon-pencil"></span>',Yii::getalias('@web').'/index.php?r=linies-comandes%2Fupdate&id='.$key->id);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
