<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.05.2016
 * Time: 21:01
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\PublicationInstance */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="periodical-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'filter-publication-form'
    ]); ?>

    <?php $formatJs = <<< JS
function formatAuthor (data, page) {
    var newData = [];
    for ( var i = 0; i < data.length; i++ ) {
        var publicationsArray = [];
        for (var j = 0; j < data[i].publications.length && j < 5; j++) {
            publicationsArray.push(data[i].publications[j].name + ((data[i].publications[j].number) ? " [" + data[i].publications[j].number + "]" : ""));
        }
        //var number = data[i].number ? " [" + data[i].number + "]" : "";
        var publications = publicationsArray.length ? publicationsArray.join('<br>') : '';

        newData.push({
            id: data[i].id,  //id part present in data
            text: "<b>" + data[i].initials + "</b><br>",
            description: publications
        });
    }


    return {results : newData};

};
JS;
    ?>

    <?php $this->registerJs($formatJs, View::POS_HEAD); ?>


    <?= $form->field($model, 'name', [
        'options' => ['class' => 'input-group-sm'],
    ])->textInput() ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'isbn', [
                'options' => ['class' => 'input-group-sm'],
            ]); ?>
        </div>
        <div class="col-md-6"><?= $form->field($model, 'recommended', [
                'options' => ['class' => 'input-group-sm'],
            ])->dropDownList(['Нет', 'Да'], ['prompt' => false]) ?></div>
    </div>

    <!-- Автор -->
    <?= $form->field($model, 'author', [
        'options' => ['class' => 'input-group-sm'],
    ])->widget(Select2::classname(), [
        'initValueText' => $model->initAuthors,
        'showToggleAll' => false,
        'size' => Select2::SMALL,
        'options' => [
            'placeholder' => '',
        ],
        'pluginOptions' => [
            'minimumInputLength' => 1,
            'allowClear' => true,
            'ajax' => [
                'delay' => 300,
                'url' => 'author/author-list',
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {search:params.term}; }'),
                'processResults' => new JsExpression('formatAuthor'),
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(data) {if (data.loading) {return data.text} return data.text + data.description} ')
        ],
    ]); ?>

    <!-- Издатель/Вид издания -->
    <div class="row">
        <div class="col-md-6"><?= $form->field($model,  'publisher_id')->widget(Select2::classname(), [
                'initValueText' => $model->initPublisher,
                'showToggleAll' => false,
                'size' => Select2::SMALL,
                'options' => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'minimumInputLength' => 1,
                    'allowClear' => true,
                    'ajax' => [
                        'url' => 'publisher/publisher-list',
                        'delay' => 300,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {search:params.term}; }'),
                    ],
                ],
            ]); ?></div>
        <div class="col-md-6"><?= $form->field($model,  'publication_type_id')->widget(Select2::classname(), [
                'initValueText' => $model->initPublicationType,
                'showToggleAll' => false,
                'size' => Select2::SMALL,
                'options' => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'minimumInputLength' => 1,
                    'allowClear' => true,
                    'ajax' => [
                        'url' => 'publication-type/publication-type-list',
                        'delay' => 300,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {search:params.term}; }'),
                    ],
                ],
            ]); ?></div>
    </div>

    <!-- Дата от/до -->
    <div class="row">
        <div class="col-xs-6"><?= $form->field($model, 'createdFrom')->widget(Select2::classname(), [
                'data' => array_reverse(array_combine(range(1700, date('Y')), range(1700, date('Y'))), true),
                'showToggleAll' => false,
                'size' => Select2::SMALL,
                'options' => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ]); ?></div>
        <div class="col-xs-6"><?= $form->field($model, 'createdTo')->widget(Select2::classname(), [
                'data' => array_reverse(array_combine(range(1700, date('Y')), range(1700, date('Y'))), true),
                'showToggleAll' => false,
                'size' => Select2::SMALL,
                'options' => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ]); ?></div>
    </div>

    <p class="line-multiple-block"></p>

    <div class="buttons-form">
        <?= Html::resetButton('Сброс '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-refresh']), ['class' => 'btn btn-default btn-refresh']); ?>
        <?= Html::submitButton('Фильтровать '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-search']), ['class' => 'btn btn-default']); ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>




