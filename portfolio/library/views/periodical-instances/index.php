<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\jui\Dialog;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Периодические экземпляры';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="publication-instance-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="buttons-grid-view">
        <?= Html::button('Добавление издания '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']), ['class' => 'btn btn-primary btn-dialog-create-publication', 'url-pjax' => 'periodical/create']) ?>
        <?= Html::button('Фильтрация '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-filter']), ['class' => 'btn btn-primary btn-dialog-filter']) ?>
        <?= Html::button('Добавление экземпляров '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']), ['class' => 'btn btn-primary btn-dialog-coming-instances', 'url-pjax' => Url::to(['coming-instances'])]) ?>
    </div>

    <?php $buttons = '<div class="pull-right buttons-grid-view">'.
        Html::button(Html::tag('span', '', ['class' => 'glyphicon glyphicon-ok']), ['class' => 'btn btn-default btn-select-all']).
        Html::button(Html::tag('span', '', ['class' => 'glyphicon glyphicon-remove']), ['class' => 'btn btn-default btn-unselect-all']).
        Html::button('В архив', ['class' => 'btn btn-warning btn-in-archive-instances', 'url-ajax' => Url::to(['in-archive'])]).
        //Html::button('Из архива', ['class' => 'btn btn-warning btn-out-archive-instances', 'url-ajax' => Url::to(['out-archive'])]).
        Html::button('Потеряны', ['class' => 'btn btn-warning btn-lost-instances', 'url-ajax' => Url::to(['lost'])]).
        //Html::button('Найдены', ['class' => 'btn btn-primary btn-found-instances', 'url-ajax' => Url::to(['found'])]).
        Html::button('Удалить', ['class' => 'btn btn-danger btn-delete-instances', 'url-ajax' => Url::to(['delete'])]).
        '</div>' ?>

    <?php Pjax::begin(['id' => 'instance-grid', 'enablePushState' => false, 'linkSelector' => 'a[data-page], a[data-sort]']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{summary}{items}{pager}'.$buttons,
        'columns' => [
            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function ($model, $key, $index) {
                    return Html::a(sprintf('%05d', $key), Url::toRoute(['view', 'id' => $key]), ['class' => 'link-dashed']);
                }
            ],
            [
                'headerOptions' => ['width' => '290'],
                'attribute' => 'publication.name'
            ],
            [
                'label' => '№',
                'attribute' => 'publication.number'
            ],
            [
                'label' => 'Статьи',
                'headerOptions' => ['width' => '420'],
                'attribute' => 'publication.article.name',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column) {
                    return $model->publication->articlesToString;
                }
            ],
            'price',
            [
                'label' => 'Ш | П',
                'attribute' => 'bookshelf.bookcase.bookcase',
                'value' => function ($model) {
                    return empty($model->bookshelf) ? null : ( $model->bookshelf->bookcase->bookcase . ' | ' . $model->bookshelf->bookshelf );
                }
            ],

            [
                'options' => ['width' => '20px'],
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil btn-dialog-update-instance', 'url-pjax' => $url]));
                    },
                    'info' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-eye-open btn-dialog-info', 'url-pjax' => $url]));
                    }
                ],
                'template' => '{info}{update}'
            ],
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

<?= $this->render('_search', ['model' => $searchModel, 'bookcases' => $bookcases, 'cycles' => $cycles]) ?>

<?php Dialog::end(); ?>

