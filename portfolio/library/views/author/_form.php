<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\publication\Author */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="author-form">

    <?php $form = ActiveForm::begin(['id' => 'update-author-form']); ?>

    <?= $form->field($model, 'initials')->textInput(['maxlength' => true]) ?>

    <p class="line-multiple-block"></p>

    <div class="buttons-form">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
