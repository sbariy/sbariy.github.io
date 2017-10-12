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
            'publication.isbn',
            'publication.bbk',
            'discipline.name',
            'cycle.name',
            'bookshelf.bookcase.bookcase',
            'bookshelf.bookshelf',
            'price',
            'date_add',
            'publication.publishing_year',
            'in_archive:boolean',
            // 'given:boolean',
            'lost:boolean',
            'publication.publisher.name',
            'publication.publicationType.name',
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
