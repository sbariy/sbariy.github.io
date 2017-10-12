<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 15.05.2016
 * Time: 17:49
 */

use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="authors-form">
    <?php $form = ActiveForm::begin(['id' => 'create-authors-form', 'action' => Url::to(['create'])]) ?>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'instances_wrapper_author', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items_authors', // required: css class selector
        'widgetItem' => '.item_authors', // required: css class
        'limit' => 10, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $authors[0],
        'formId' => 'create-authors-form',
        'formFields' => [
            'initials',
        ],
    ]); ?>

    <p class="line-multiple-block"><?= Html::label('Авторы') ?> <span class="add-item pull-right"><i class="glyphicon glyphicon-plus"></i></span></p>

    <div class="authors multiple">
        <div class="container-items_authors">
            <?php foreach ($authors as $i => $author): ?>

                <div class="item_authors form-group"><!-- widgetBody -->
                    <?php
                    // necessary for update action.
                    if (! $author->isNewRecord) {
                        echo Html::activeHiddenInput($author, "[{$i}]id");
                    }
                    ?>
                    <?= $form->field($author, "[{$i}]initials", [
                        'template' => '<div class="input-group input-group-sm">{input}<span class="input-group-btn"><button type="button" class="remove-item btn btn-danger"><i class="glyphicon glyphicon-minus"></i></button></span></div>{error}',
                        'inputOptions' => ['placeholder' => $author->getAttributeLabel('initials')]
                    ])->textInput(['maxLength' => true]) ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <p class="line-multiple-block"></p>

    <?php DynamicFormWidget::end(); ?>

    <div class="buttons-form">
        <?= Html::resetButton(Html::tag('span', '', ['class' => 'glyphicon glyphicon-refresh']), ['class' => 'btn btn-primary btn-refresh']) ?>
        <?= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
