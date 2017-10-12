<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\publication\Author */

$this->title = 'Create Author';
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formAuthors', compact('authors')) ?>

</div>
