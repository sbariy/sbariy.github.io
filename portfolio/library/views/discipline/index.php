<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\instance\DisciplineSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дисциплины';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discipline-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="buttons-grid-view">
        <?= Html::button('Добавление дисциплин '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']), ['class' => 'btn btn-primary btn-dialog-create-disciplines', 'url-pjax' => Url::to(['create'])]) ?>
    </div>
    <?php Pjax::begin(['id' => 'discipline-grid', 'enablePushState' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            [
                'label' => 'Входит в циклы',
                'format' => 'raw',
                'attribute' => 'cycle.name',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'cycle.id',
                    'data' => $cycles,
                    'options' => ['prompt' => ''],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]),
                'value' => function ($model) {
                    return $model->getCyclesToString();
                }
            ],
            [
                'options' => ['width' => '20px'],
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil btn-dialog-update-discipline', 'url-pjax' => $url]));
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
