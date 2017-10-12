<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\publication\PublicationTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Виды изданий';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publication-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="buttons-grid-view">
        <?= Html::button('Добавление видов издания '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']), ['class' => 'btn btn-primary btn-dialog-create-publication-types', 'url-pjax' => Url::to(['create'])]) ?>
    </div>
<?php Pjax::begin(['id' => 'publication-type-grid']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'name',

            [
                'options' => ['width' => '20px'],
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil btn-dialog-update-publication-type', 'url-pjax' => $url]));
                    },

                    'delete' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash btn-delete-action', 'url-ajax' => $url, 'element-id' => $key]));
                    },
                ],
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
