<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\material\PublicationMaterial */

$this->title = 'Create Publication Material';
$this->params['breadcrumbs'][] = ['label' => 'Publication Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publication-material-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
