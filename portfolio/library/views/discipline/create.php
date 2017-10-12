<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\instance\Discipline */

$this->title = 'Create Discipline';
$this->params['breadcrumbs'][] = ['label' => 'Disciplines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discipline-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
