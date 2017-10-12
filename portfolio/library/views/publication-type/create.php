<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\publication\PublicationType */

$this->title = 'Create Publication Type';
$this->params['breadcrumbs'][] = ['label' => 'Publication Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publication-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
