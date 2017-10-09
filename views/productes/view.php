<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Productes */

$this->title = "Veure producte";
$this->params['breadcrumbs'][] = ['label' => 'Productes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="productes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualitzar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Esborrar', ['delete', 'id' => $model->id], [
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
            ['attribute'=>'categoria_fk', 'label'=>'Categoria'],
            'descripcio',
            'stock',
            'pendents',
        ],
    ]) ?>

</div>
