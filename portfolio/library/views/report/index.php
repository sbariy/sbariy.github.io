<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.06.2016
 * Time: 14:35
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

$this->title = 'Отчёты добавленных изданий';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="report-index-form" style="width: 480px; margin: 0 auto">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin([
        //'layout' => 'horizontal',
        'id' => 'report_form',
    ]) ?>

    <?= $form->field($model, '_type')->dropDownList(['periodical' => 'Периодика', 'book' => 'Книги']) ?>
    <?= $form->field($model, 'addedFrom')
        ->widget(DatePicker::classname(), [
            'size' => 'sm',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'removeButton' => ['icon' => 'trash'],
            'pickerButton' => false,
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
                'todayHighlight' => true,
            ]
    ]); ?>
    <?= $form->field($model, 'addedTo')
    ->widget(DatePicker::classname(), [
            'size' => 'sm',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'removeButton' => ['icon' => 'trash'],
            'pickerButton' => false,
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
                'todayHighlight' => true,
            ]
        ]); ?>

    <div class="buttons-form">
        <?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end() ?>
</div>