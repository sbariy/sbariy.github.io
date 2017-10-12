<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.05.2016
 * Time: 21:01
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\PublicationInstance */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="periodical-instances-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'filter-instance-form'
    ]); ?>

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <span class="panel-title"><span class="glyphicon glyphicon-menu-down" style="vertical-align: text-bottom">&nbsp;</span><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">По дате</a></span>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <!-- Дата от/до -->
                    <div class="row">
                        <div class="col-xs-6"><?= $form->field($model, 'publication.releasedFrom')->widget(DatePicker::classname(), [
                                'size' => 'sm',
                                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                'removeButton' => ['icon' => 'trash'],
                                'pickerButton' => false,
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'autoclose' => true,
                                    'todayHighlight' => true,
                                ]
                            ]); ?></div>
                        <div class="col-xs-6"><?= $form->field($model, 'publication.releasedTo')->widget(DatePicker::classname(), [
                                'size' => 'sm',
                                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                'removeButton' => ['icon' => 'trash'],
                                'pickerButton' => false,
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'autoclose' => true,
                                    'todayHighlight' => true,
                                ]
                            ]); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6"><?= $form->field($model, 'addedFrom')->widget(DatePicker::classname(), [
                                'size' => 'sm',
                                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                'removeButton' => ['icon' => 'trash'],
                                'pickerButton' => false,
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'autoclose' => true,
                                    'todayHighlight' => true,
                                ]
                            ]); ?></div>
                        <div class="col-xs-6"><?= $form->field($model, 'addedTo')->widget(DatePicker::classname(), [
                                'size' => 'sm',
                                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                'removeButton' => ['icon' => 'trash'],
                                'pickerButton' => false,
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'autoclose' => true,
                                    'todayHighlight' => true,
                                ]
                            ]); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
                <span class="panel-title"><span class="glyphicon glyphicon-menu-down" style="vertical-align: text-bottom">&nbsp;</span><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">По местоположению</a></span>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="panel-body">
                    <?php /* echo $form->field($model, 'given', [
                        'options' => ['class' => 'input-group-sm'],
                    ])->dropDownList(['Нет', 'Да'], ['prompt' => false]) */ ?>

                    <div class="row">
                        <div class="col-md-6"><?= $form->field($model, 'bookshelf.bookcase.bookcase', [
                                'options' => ['class' => 'input-group-sm'],
                                'inputOptions' => ['class' => 'depdrop-child form-control']
                            ])->dropDownList($bookcases, ['id' => 'bookcase-filter', 'prompt' => false]); ?></div>
                        <div class="col-md-6"><?= $form->field($model, 'bookshelf.bookshelf', [
                                'options' => ['class' => 'input-group-sm'],
                            ])->widget(DepDrop::classname(), [
                                'options' => ['id' => 'bookshelf-filter'],
                                'pluginOptions' => [
                                    'placeholder' => '',
                                    'depends' => ['bookcase-filter'],
                                    'url' => \yii\helpers\Url::to(['bookshelf'])
                                ]
                            ]); ?></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6"><?= $form->field($model, 'cycle_id', [
                                'options' => ['class' => 'input-group-sm'],
                                'inputOptions' => ['class' => 'depdrop-child form-control']
                            ])->dropDownList(ArrayHelper::map($cycles, 'id', 'name'), ['id' => 'cycle-filter', 'prompt' => false]); ?></div>
                        <div class="col-md-6"><?= $form->field($model, 'discipline_id', [
                                'options' => ['class' => 'input-group-sm'],
                            ])->widget(DepDrop::classname(), [
                                'options' => ['id' => 'discipline-filter'],
                                'pluginOptions' => [
                                    'placeholder' => '',
                                    'depends' => ['cycle-filter'],
                                    'url' => \yii\helpers\Url::to(['discipline'])
                                ]
                            ]); ?></div>
                    </div>

                    <?= $form->field($model, 'in_archive', [
                        'options' => ['class' => 'input-group-sm'],
                    ])->dropDownList(['Нет', 'Да'], ['prompt' => false]) ?>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree">
                <span class="panel-title"><span class="glyphicon glyphicon-menu-down" style="vertical-align: text-bottom">&nbsp;</span><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">По состоянию</a></span>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6"><?= $form->field($model, 'publication.recommended', [
                                'options' => ['class' => 'input-group-sm'],
                            ])->dropDownList(['Нет', 'Да'], ['prompt' => false]) ?></div>
                        <div class="col-md-6"><?= $form->field($model, 'lost', [
                                'options' => ['class' => 'input-group-sm'],
                            ])->dropDownList(['Нет', 'Да'], ['prompt' => false]) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'publication.name', [
        'options' => ['class' => 'input-group-sm'],
    ])->textInput() ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'publication.issn', [
                'options' => ['class' => 'input-group-sm'],
            ]); ?>
        </div>
        <div class="col-md-6"><?= $form->field($model, 'id', [
                'options' => ['class' => 'input-group-sm'],
                'inputOptions' => ['placeholder' => '']
            ]); ?></div>
    </div>


    <div class="row">
        <div class="col-xs-6"><?= $form->field($model, 'priceFrom', [
                'options' => ['class' => 'input-group-sm'],
            ]); ?></div>
        <div class="col-xs-6"><?= $form->field($model, 'priceTo', [
                'options' => ['class' => 'input-group-sm'],
            ]); ?></div>
    </div>

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

    <!-- Автор -->
    <?= $form->field($model, 'publication.author_id', [
        'options' => ['class' => 'input-group-sm'],
    ])->widget(Select2::classname(), [
        'initValueText' => empty($model->publication) ? false : $model->publication->initAuthors,
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
        <div class="col-md-6"><?= $form->field($model,  'publication.publisher_id')->widget(Select2::classname(), [
                //'initValueText' => $model->publication->initPublisher(),
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
        <div class="col-md-6"><?= $form->field($model,  'publication.publication_type_id')->widget(Select2::classname(), [
                //'initValueText' => $model->publication->initPublicationType,
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



    <?= $form->field($model, 'publication.article.name', [
        'options' => ['class' => 'input-group-sm'],
    ]); ?>

    <p class="line-multiple-block"></p>

    <div class="buttons-form">
        <?= Html::resetButton('Сброс '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-refresh']), ['class' => 'btn btn-default btn-refresh btn-filter']); ?>
        <?= Html::submitButton('Фильтровать '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-search']), ['class' => 'btn btn-default']); ?>
    </div>

    <?php // $form->field($model, 'given')->checkbox(); ?>

    <?php ActiveForm::end(); ?>
</div>




