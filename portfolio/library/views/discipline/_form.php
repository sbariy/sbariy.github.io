<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\instance\Discipline */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="discipline-form">

    <?php $form = ActiveForm::begin(['id' => 'update-discipline-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <p class="line-multiple-block"></p>

    <div class="buttons-form">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
