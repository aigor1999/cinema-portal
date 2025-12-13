<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\Models\Seance $model */

$this->title = 'Добавить сеанс';
$this->params['breadcrumbs'][] = ['label' => 'Сеансы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
