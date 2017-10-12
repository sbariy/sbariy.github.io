<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24.04.2016
 * Time: 23:13
 */

use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use yii\web\View;

?>

<div class="periodical-form">
    <?php $form = ActiveForm::begin([
        'id' => $publication->isNewRecord ? 'create-publication-form' : 'update-publication-form',
        'action' => $publication->isNewRecord ? Url::to(['create']) : Url::to(['update'])]) ?>

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

    <div class="row">
        <div class="col-md-10">
            <?= $form->field($publication, 'name', [
                'options' => ['class' => 'input-group-sm'],
                'inputOptions' => ['placeholder' => $publication->getAttributeLabel('name')]
            ])->textInput() ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($publication, 'bbk', [
                'options' => ['class' => 'input-group-sm'],
                'inputOptions' => ['placeholder' => $publication->getAttributeLabel('bbk')]
            ])->textInput() ?>
        </div>
    </div>

    <?= $form->field($publication,  'authorsArray', [
        'template' => '{label}'. Html::tag('span', '', ['class' => 'pull-right btn-dialog-create-authors glyphicon glyphicon-plus', 'url-pjax' => 'author/create']) .'{input}{error}',
    ])->widget(Select2::classname(), [
        'initValueText' => $publication->initAuthors,
        'showToggleAll' => false,
        'size' => Select2::SMALL,
        'options' => [
            'placeholder' => 'Поиск авторов...',
            'multiple' => true
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

    <div class="row">
        <div class="col-md-6"><?= $form->field($publication, 'isbn', [
                'options' => ['class' => 'input-group-sm'],
                'inputOptions' => ['placeholder' => $publication->getAttributeLabel('isbn')]
            ])->textInput() ?></div>
        <div class="col-md-6"><?= $form->field($publication, 'publishing_year', [
                'options' => ['class' => 'input-group-sm'],
            ])->widget(Select2::classname(), [
                'data' => array_reverse(array_combine(range(1700, date('Y')), range(1700, date('Y'))), true),
                'showToggleAll' => false,
                'size' => Select2::SMALL,
                'options' => [
                    'placeholder' => 'Год выпуска',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ]) ?></div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($publication,  'publisher_id', [
                'template' => '{label}'. Html::tag('span', '', ['class' => 'pull-right btn-dialog-create-publishers glyphicon glyphicon-plus', 'url-pjax' => 'publisher/create']) .'{input}{error}',
            ])->widget(Select2::classname(), [
                'initValueText' => $publication->initPublisher,
                'showToggleAll' => false,
                'size' => Select2::SMALL,
                'options' => [
                    'placeholder' => 'Поиск издателей ...',
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
            ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($publication,  'publication_type_id', [
                'template' => '{label}'. Html::tag('span', '', ['class' => 'pull-right btn-dialog-create-publication-types glyphicon glyphicon-plus', 'url-pjax' => 'publication-type/create']) .'{input}{error}',
            ])->widget(Select2::classname(), [
                'initValueText' => $publication->initPublicationType,
                'showToggleAll' => false,
                'size' => Select2::SMALL,
                'options' => [
                    'placeholder' => 'Поиск видов изданий ...',
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
            ]); ?>
        </div>
    </div>

    <?= $form->field($publication, 'recommended', [
        'options' => ['class' => 'input-group-sm'],
    ])->checkbox()->label('Рекомендовано Министерством Образования') ?>

    <?= $form->field($publication, 'annotation', [
        'options' => ['class' => 'input-group-sm'],
        'inputOptions' => ['placeholder' => $publication->getAttributeLabel('annotation')]
    ])->textarea() ?>

    <p class="line-multiple-block"></p>

    <div class="buttons-form">
        <?php if ($publication->isNewRecord) {
            echo Html::resetButton('Сброс '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-refresh']), ['class' => 'btn btn-primary btn-refresh']);
        } ?>
        <?= Html::submitButton($publication->isNewRecord ? 'Создать' : 'Обновить', ['class' => 'btn btn-primary']) ?>
    </div>



    <?php ActiveForm::end() ?>
</div>
