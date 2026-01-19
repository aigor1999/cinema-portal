<?php

use common\Models\Film;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var Film $searchModel */

$this->title = 'Фильмы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить фильм', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            [
                'attribute' => 'photoUrl',
                'format' => 'html',
                'value' => function($model) {
                    return Html::img($model->photoUrl, [
                        'style' => 'width:200px;'
                    ]);
                }
            ],
            [
                'attribute' => 'description',
                'format' => 'ntext',
                'filter' => false
            ],
            [
                'attribute' => 'length',
                'filter' => Html::activeTextInput($searchModel, 'length', ['type' => 'number'])
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
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Film $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
