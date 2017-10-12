<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\instance\BookcaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Шкафы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bookcase-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="buttons-grid-view">
        <?= Html::button('Добавление шкафа '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']), ['class' => 'btn-dialog-create-bookcase btn btn-primary ', 'url-pjax' => \yii\helpers\Url::to(['create'])])?>
    </div>

<?php Pjax::begin(['id' => 'bookcase-grid', 'enablePushState' => false]); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [

        'bookcase',
        [
            'label' => 'Кол-во полок',
            'attribute' => 'amount',
            'format' => 'raw',
            'value' => 'amount'
        ],

        [
            'options' => ['width' => '20px'],
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash btn-delete-action', 'url-ajax' => $url, 'element-id' => $key]));
                },
            ],
            'template' => '{delete}'
        ],
    ],
]); ?>
<?php Pjax::end(); ?></div>
