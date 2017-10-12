<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\user\User */

$this->title = 'Редактирование библиотекаря: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Библиотекари', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
