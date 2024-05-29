<?php

use app\models\Event;
use app\models\Organization;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\EventSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'date',
            'description',
            [
                'attribute' => 'name',
                'filter' => false,
                'label' => 'Organizations',
                'value' => function ($model) {
                    return implode(', ',ArrayHelper::getColumn($model->organizations, 'name'));
                }
            ],
        ],
    ]); ?>


</div>
