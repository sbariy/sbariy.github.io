<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\publication\PublicationPeriodical */

?>
<div class="publication-periodical-view">
    <?= DetailView::widget([
        'model' => $publication,
        'attributes' => [
            'name',
            'bbk',
            'id',
            'isbn',
            'publisher.name',
            'publicationType.name',
            [
                'label' => 'Авторы',
                'format' => 'raw',
                'value' => $publication->authorsToString
            ],
            'publishing_year',
            'date_add',
            'annotation:ntext',
            'recommended:boolean',
        ],
    ]) ?>
</div>
