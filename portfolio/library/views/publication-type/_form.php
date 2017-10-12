<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\publication\PublicationType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="publication-type-form">

    <?php $form = ActiveForm::begin(['id' => 'update-publication-type-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <p class="line-multiple-block"></p>

    <div class="buttons-form">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
