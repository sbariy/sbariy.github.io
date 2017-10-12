<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\publication\PublicationType */

$this->title = 'Update Publication Type: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Publication Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="publication-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
