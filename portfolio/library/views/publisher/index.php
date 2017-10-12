<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\publication\PublisherSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Издатели';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publisher-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="buttons-grid-view">
        <?= Html::button('Добавить издателей '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']), ['class' => 'btn btn-primary btn-dialog-create-publishers', 'url-pjax' => Url::to(['create'])]) ?>
    </div>
<?php Pjax::begin(['id' => 'publisher-grid', 'enablePushState' => false]); ?>
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
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil btn-dialog-update-publisher', 'url-pjax' => $url]));
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
