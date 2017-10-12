<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\models\instance\CycleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Учебные циклы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cycle-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="buttons-grid-view">
        <?= Html::button('Добавление цикла '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']), ['class' => 'btn-dialog-create-cycle btn btn-primary', 'url-pjax' => \yii\helpers\Url::to(['create'])]) ?>
    </div>
    <?php Pjax::begin(['id' => 'cycle-grid', 'enablePushState' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            [
                'label' => 'Дисциплины',
                'format' => 'raw',
                'attribute' => 'disciplines.name',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'disciplinesArray',
                    'data' => $disciplines,
                    'options' => ['prompt' => ''],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]),
                'value' => function ($model, $key) {
                    return $model->getDisciplinesToString();
                }
            ],
            [
                'options' => ['width' => '95px'],
                'label' => 'Принятие',
                'attribute' => 'year_adoption',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'year_adoption',
                    'data' => array_reverse(array_combine(range(2000, date('Y')), range(2000, date('Y'))), true),
                    'options' => ['prompt' => ''],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]),
                'value' => function ($model, $key) {
                    return $model->year_adoption ? $model->year_adoption . 'г.' : null;
                }
            ],
            [
                'options' => ['width' => '95px'],
                'label' => 'Длит.',
                'attribute' => 'duration',
                'format' => 'raw',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'duration',
                    'data' => array_combine(range(1, 15), range(1, 15)),
                    'options' => ['prompt' => ''],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]),
                'value' => function ($model) {
                    if (!$model->duration) {
                        return null;
                    }

                    switch ($model->duration) {
                        case 1: $year = 'год'; break;
                        case 2:
                        case 3:
                        case 4: $year = 'года'; break;
                        default: $year = 'лет'; break;
                    }

                    return $model->duration .'&nbsp'. $year;
                }
            ],
            [
                'options' => ['width' => '95px'],
                'label' => 'Окончание',
                'value' => function ($model) {
                    return $model->yearEnding ? $model->yearEnding . 'г.' : null;
                }
            ],
            [
                'options' => ['width' => '20px'],
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil btn-dialog-update-cycle', 'url-pjax' => $url]));
                    },

                    'delete' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash btn-delete-action', 'url-ajax' => $url, 'element-id' => $key]));
                    },
                ],
                'template' => '{update}{delete}'
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
