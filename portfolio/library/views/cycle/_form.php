<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\instance\Cycle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cycle-form">

    <?php $form = ActiveForm::begin(['id' => $model->isNewRecord ? 'create-cycle-form' : 'update-cycle-form']); ?>
    
    <?= $form->field($model, 'name', [
        'options' => ['class' => 'input-group-sm'],
    ]) ?>

    <div class="row">
        <div class="col-md-6"><?= $form->field($model, 'year_adoption', [
                'options' => ['class' => 'input-group-sm'],
                'inputOptions' => ['prompt' => '']
            ])->dropDownList(array_reverse(array_combine(range(2000, date('Y')), range(2000, date('Y'))), true)) ?></div>
        <div class="col-md-6"><?= $form->field($model, 'duration', [
                'options' => ['class' => 'input-group-sm'],
                'inputOptions' => ['type' => 'number', 'max' => 15, 'min' => 1]
            ])?></div>
    </div>

    <?= $form->field($model, 'disciplinesArray', [
        'template' => Html::tag('p', '{label}', ['class' => 'line-multiple-block']) . "\n{input}\n{error}"
    ])->checkboxList(\yii\helpers\ArrayHelper::map($disciplines, 'id', 'name'), ['class' => 'disciplines']) ?>

    <p class="line-multiple-block"></p>

    <div class="buttons-form">
        <?= Html::button(Html::tag('span', '', ['class' => 'glyphicon glyphicon-ok']), ['class' => 'btn-select-all-checkbox-form btn btn-default']) ?>
        <?= Html::button(Html::tag('span', '', ['class' => 'glyphicon glyphicon-remove']), ['class' => 'btn-unselect-all-checkbox-form btn btn-default']) ?>

        <?php if ($model->isNewRecord): ?>
        <?= Html::resetButton('Сброс '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-refresh']), ['class' => 'btn btn-primary btn-refresh']) ?>
        <?php endif; ?>

        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
