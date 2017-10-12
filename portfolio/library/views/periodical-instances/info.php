<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $instance app\models\instance\PublicationInstance */

?>
<div class="publication-instance-info">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'publication.name',
            'publication.number',
            'id',
            'publication.issn',
            'discipline.name',
            'cycle.name',
            'bookshelf.bookcase.bookcase',
            'bookshelf.bookshelf',
            'price',
            'date_add',
            'publication.release_date',
            'in_archive:boolean',
            // 'given:boolean',
            'lost:boolean',
            'publication.publisher.name',
            'publication.publicationType.name',
            [
                'label' => 'Статьи',
                'format' => 'raw',
                'value' => $model->publication->articlesToString
            ],
            [
                'label' => 'Авторы',
                'format' => 'raw',
                'value' => $model->publication->authorsToString
            ],
            'publication.annotation:ntext',
            'publication.recommended:boolean'
        ],
    ]) ?>

</div>
