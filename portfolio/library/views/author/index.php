<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\publication\AuthorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="buttons-grid-view">
        <?= Html::button('Добавление авторов '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']), ['class' => 'btn btn-primary btn-dialog-create-authors', 'url-pjax' => Url::to(['create'])]) ?>
    </div>

    <?php Pjax::begin(['id' => 'author-grid', 'enablePushState' => false]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [

                'initials',

                [
                    'options' => ['width' => '20px'],
                    'class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'update' => function ($url) {
                            return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil btn-dialog-update-author', 'url-pjax' => $url]));
                        },

                        'delete' => function ($url, $model, $key) {
                            return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash btn-delete-action', 'url-ajax' => $url, 'element-id' => $key]));
                        },
                    ],
                    'template' => '{update} {delete}'
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
