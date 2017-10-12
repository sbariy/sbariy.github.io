<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 06.05.2016
 * Time: 8:50
 *
 * @var $this yii\web\View
 * @var $model app\models\instance\PublicationInstance
 */

use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
use yii\web\JsExpression;
use yii\web\View;

?>


<div class="coming-instance">
    <?php $form = ActiveForm::begin(['id' => !$model->isNewRecord ? 'update-instance-form' : 'coming-instances-form', 'action' => Url::to([$model->isNewRecord ? 'coming-instances' : 'update-instance'])]); ?>

    <?php $formatJs = <<< JS
function formatPublication (data, page) {
   var newData = [];
    for ( var i = 0; i < data.length; i++ ) {

        var publicationType = "<i style='font-size: 12px'>-- " + (data[i].publicationType ? data[i].publicationType : 'не указано') + "</i>";
        var number = data[i].number ? " [" + data[i].number + "]" : "";

        var authorsArray = [];
        for (var j = 0; j < data[i].authors.length && j < 5; j++) {
            authorsArray.push(data[i].authors[j].initials);
        }
        var authors = authorsArray.length ? "Авторы: " + authorsArray.join(', ') : "";

        newData.push({
            id: data[i].id,  //id part present in data
            text: "<b>" + data[i].name + number + "</b><br>",
            description: publicationType + "<br>" + authors
        });
    }
    return {results : newData};

};
JS;
    ?>

    <?php $this->registerJs($formatJs, View::POS_HEAD); ?>

    <?php if ($model->isNewRecord) : ?>
    <?= $form->field($model, 'publication_id', [
        'options' => ['class' => 'input-group-sm'],
    ])->widget(Select2::className(), [
        'options' => [
            'prompt' => ''
        ],
        'pluginOptions' => [
            'minimumInputLength' => 1,
            'allowClear' => true,
            'ajax' => [
                'delay' => 300,
                'url' => Url::to(["/$typeInstance/publication-list"]),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {search:params.term}; }'),
                'processResults' => new JsExpression('formatPublication'),
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(data) {if (data.loading) {return data.text} return data.text + data.description} ')
        ],
    ]); ?>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'cycle_id', [
                'options' => ['class' => 'input-group-sm'],
                'inputOptions' => ['class' => 'depdrop-child form-control']
            ])->dropDownList(ArrayHelper::map($cycles, 'id', 'name'), ['id' => 'cycle', 'prompt' => '']); ?>
        </div>
        <div class="col-md-6">
            <?= Html::activeHiddenInput($model, 'discipline_id', ['value' => '']); ?>

            <?= $form->field($model, 'discipline_id', [
                'options' => ['class' => 'input-group-sm'],
                'inputOptions' => ['class' => 'depdrop-child']
            ])->widget(DepDrop::classname(), [
                'data' => empty($model->discipline) ? ['' => ''] : [$model->discipline_id => $model->discipline->name],
                'options' => ['id' => 'discipline'],
                'pluginOptions' => [
                    'placeholder' => false,
                    'depends' => ['cycle'],
                    'url' => Url::to(['discipline']),
                ]
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'bookcase', [
                'options' => ['class' => 'input-group-sm'],
                'inputOptions' => ['class' => 'depdrop-child form-control']
            ])->dropDownList($bookcases, ['id' => 'bookcase', 'prompt' => '', 'disabled' => $model->in_archive || $model->lost || $model->given ?: false]); ?>
        </div>

        <div class="col-md-6">
            <?= Html::activeHiddenInput($model, 'bookshelf_id', ['value' => '']); ?>

            <?= $form->field($model, 'bookshelf_id', [
                'options' => ['class' => 'input-group-sm'],
                'inputOptions' => ['class' => 'depdrop-child']
            ])->widget(DepDrop::classname(), [
                'data' => empty($model->bookshelf) ? ['' => ''] : [$model->bookshelf_id => $model->bookshelf->bookshelf],
                'options' => ['id' => 'bookshelf', 'disabled' => $model->in_archive || $model->lost || $model->given ?: false],
                'pluginOptions' => [
                    'placeholder' => false,
                    'depends' => ['bookcase'],
                    'url' => Url::to(['bookshelf']),
                ]
            ]); ?>
        </div>
    </div>

    <?php if ($model->isNewRecord) echo $form->field($model, 'in_archive', ['options' => ['class' => 'field-in_archive']])->checkbox() ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'price', [
                'options' => ['class' => 'input-group-sm'],
                'inputOptions' => ['placeholder' => 'цена']
            ])->input('number', ['min' => '0', 'max' => '10000']); ?>
        </div>

        <?php if ($model->isNewRecord) : ?>
        <div class="col-md-6">
            <?= $form->field($model, 'amount', [
                'options' => ['class' => 'input-group-sm'],
                'inputOptions' => ['placeholder' => 'кол-во']
            ])->input('number', ['min' => '1', 'max' => '50']); ?>
        </div>
        <?php endif; ?>
    </div>

    <p class="line-multiple-block"></p>

    <div class="buttons-form">
        <?php if ($model->isNewRecord) echo Html::resetButton('Сброс '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-refresh']), ['class' => 'btn btn-primary btn-refresh']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
