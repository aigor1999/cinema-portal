<?php

use frontend\assets\BackendUploadAsset;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */

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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'film',            
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
            'datetime:datetime',
            'price',
            'rating'
        ],
    ]); ?>
</div>
