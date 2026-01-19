<?php

use frontend\assets\BackendUploadAsset;
use kartik\datetime\DateTimePicker;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\Models\Seance $searchModel */

$this->title = 'Кинотеатр Блокбастер';
$backendUpload = BackendUploadAsset::register($this);

?>
<div class="site-index">
    <div class="mb-4 bg-transparent rounded-3">
        <div class="container-fluid text-center">
            <h1 class="display-4">Кинотеатр Блокбастер</h1>
            <p class="fs-5 fw-light">Расписание сеансов</p>
        </div>
    </div>

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
            //'photo',    
            [
                'attribute' => 'photo',
                'format' => 'html',
                'value' => function ($model) use($backendUpload) {
                    return Html::img("$backendUpload->baseUrl/$model->photo", [
                        'style' => 'width:200px;'
                    ]);
                }
            ],
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
                'attribute' => 'rating',
                'filter' => [
                    '0+' => '0+',
                    '6+' => '6+',
                    '12+' => '12+',
                    '16+' => '16+',
                    '18+' => '18+'
                ]
            ],
        ],
    ]); ?>
</div>
