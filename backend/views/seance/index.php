<?php

use common\Models\Seance;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var Seance $searchModel */

$this->title = 'Сеансы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seance-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить сеанс', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'film',
            [
                'attribute' => 'film',
                'filter' => Html::activeTextInput($searchModel, 'name')
            ],
            //'datetime:datetime',
            [
                'attribute' => 'datetime',
                'format' => 'datetime',
                'filter' => DateTimePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'datetime',
                    'type' => DateTimePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'format' => 'dd.mm.yyyy hh:ii'
                    ]
                ])
            ],
            [
                'attribute' => 'price',
                'filter' => Html::activeTextInput($searchModel, 'price', ['type' => 'number'])
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Seance $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
