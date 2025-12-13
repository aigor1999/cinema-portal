<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\Models\Film $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="film-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php if(!$model->isNewRecord): ?>
        <div class="form-group">
            <?= Html::img($model->photoUrl, [ 'style' => 'width:200px;']); ?>
        </div>
    <?php endif;?>

    <?= $form->field($model, 'upload')->fileInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'length')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'rating')->dropDownList([
        '0+' => '0+',
        '6+' => '6+',
        '12+' => '12+',
        '16+' => '16+',
        '18+' => '18+'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
