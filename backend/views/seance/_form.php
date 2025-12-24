<?php

use common\models\Film;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\Models\Seance $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="seance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'film_id')->dropDownList(ArrayHelper::map(Film::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'datetime', [
        'inputOptions' => ['value' => !$model->isNewRecord ? 
            Yii::$app->formatter->asDatetime($model->datetime) : '' ]
    ])->widget(DateTimePicker::className(), [
        'type' => DateTimePicker::TYPE_INPUT,
        'pluginOptions' => [
            'format' => 'dd.mm.yyyy hh:ii'
        ]
    ]) ?>

    <?= $form->field($model, 'price')->textInput(['type' => 'number']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
