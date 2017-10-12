<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\Dialog;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Периодические издания';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publication-periodical-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="buttons-grid-view">
        <?= Html::button('Фильтрация '. Html::tag('span', '', ['class' => 'glyphicon glyphicon-filter']), ['class' => 'btn btn-primary btn-dialog-filter']) ?>
        <?= Html::button('Добавление издания '. Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']), ['class' => 'btn btn-primary btn-dialog-create-publication', 'url-pjax' => Url::to(['create'])]) ?>
    </div>


    <?php $buttons = '<div class="pull-right buttons-grid-view">'.
        Html::button(Html::tag('span', '', ['class' => 'glyphicon glyphicon-ok']), ['class' => 'btn btn-default btn-select-all']).
        Html::button(Html::tag('span', '', ['class' => 'glyphicon glyphicon-remove']), ['class' => 'btn btn-default btn-unselect-all']).
        Html::button('В архив', ['class' => 'btn btn-warning btn-in-archive', 'url-ajax' => Url::to(['in-archive'])]).
        Html::button('Удалить', ['class' => 'btn btn-danger btn-delete', 'url-ajax' => Url::to(['delete'])]).
        '</div>' ?>

    <?php Pjax::begin(['id' => 'publication-grid', 'enablePushState' => false]); ?>
    <?= GridView::widget([
        'layout' => "{summary}\n{items}\n{pager}" . $buttons,
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            [
                'label' => '№',
                'attribute' => 'number'
            ],
            'issn',
            'publisher.name',
            [
                'headerOptions' => ['width' => '300'],
                'label' => 'Статьи',
                'attribute' => 'article.name',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column) {
                    return $model->articlesToString;
                }
            ],
            'release_date',

            ['class' => 'app\utilities\InstancesColumn'],
            [
                'options' => ['width' => '20px'],
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'info' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-eye-open btn-dialog-info', 'url-pjax' => $url]));
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil btn-dialog-update-publication', 'url-pjax' => $url]));
                    },
                ],
                'template' => '{info}{update}'
            ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php Dialog::begin([
    'id' => 'dialog-filter',
    'clientOptions' => [
        'autoOpen' => false,
        'modal' => false,
        'width' => 500,
        'title' => 'Фильтрация'
    ]
]) ?>

<?= $this->render('_search', ['model' => $searchModel]) ?>

<?php Dialog::end(); ?>



