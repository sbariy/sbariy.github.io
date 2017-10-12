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
            'number',
            'id',
            'issn',
            'publisher.name',
            'publicationType.name',
            [
                'label' => 'Статьи',
                'format' => 'raw',
                'value' => $publication->articlesToString
            ],
            [
                'label' => 'Авторы',
                'format' => 'raw',
                'value' => $publication->authorsToString
            ],
            'release_date',
            'date_add',
            'annotation:ntext',
            'recommended:boolean',
        ],
    ]) ?>
</div>
