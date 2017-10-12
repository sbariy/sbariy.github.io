<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\instance\Bookcase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bookcase-form">

    <?php $form = ActiveForm::begin(['id' => 'bookcase-form', 'action' => Url::to(['create'])]); ?>

    <div class="row">
        <div class="col-md-8"><?= $form->field($model, 'bookcase', [
                'options' => ['class' => 'input-group-sm'],
                'inputOptions' => ['placeholder' => 'Номер шкафа', 'class' => 'form-control']
            ]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'amount_bookshelves', [
                'options' => ['class' => 'input-group-sm'],
                'inputOptions' => ['placeholder' => 'Кол-во полок', 'class' => 'form-control']
            ]) ?></div>
    </div>

    <p class="line-multiple-block"></p>

    <div class="buttons-form">
        <?= Html::resetButton('Сброс', ['class' => 'btn btn-primary btn-refresh']) ?>
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
