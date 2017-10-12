<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Библиотечный фонд СПБГЭУ';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Добро пожаловать <?= Yii::$app->user->identity->name ?>!</h1>

        <p class="lead">Управление приложением осуществляется с помощью разделов расположенных в меню выше </p>

        <p>Необходимые <a href="periodical-instances">периодические</a> или <a href="book-instances">книжные</a> экземпляры можно найти в полях поиска расположенных ниже, однако
            настоятельно рекомендуется это делать в соответствующих разделах</p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <h2>Периодические издания</h2>
                <br>

                <?php $form = ActiveForm::begin(['method' => 'get', 'id' => 'search-periodical-filter', 'action' => 'periodical-instances']); ?>

                <?php Pjax::begin(['id' => 'search-periodical-pjax', 'enablePushState' => false, 'linkSelector' => '.periodical-field a']) ?>
                <?= $form->field($pModel, isset($periodicalAttribute) ? $periodicalAttribute : 'id', [
                    'options' => ['class' => 'periodical-field'],
                    'template' => '<div class="input-group">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $label . ' <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="' . Url::current(['p-attribute' => 'id']) . '">Инв. номер</a></li>
                            <li><a href="' . Url::current(['p-attribute' => 'publication.name']) . '">Название</a></li>
                            <li><a href="' . Url::current(['p-attribute' => 'publication.issn']) . '">ISSN</a></li>
                            <li><a href="' . Url::current(['p-attribute' => 'publication.article.name']) . '">Статья</a></li>
                        </ul>
                    </div>{input}</div>'
                ]) ?>
                <?php Pjax::end() ?>

                <?php ActiveForm::end() ?>

                <br>
                <p>В настоящее время библиотека насчитывает <b><?= $pCountInstance ?></b> экземпляров из <b><?= $pCountPublication ?></b> периодических <a href="periodical">изданий</a> </p>
                <p>За последний месяц было добавлено <b><?= $pCountInstanceMonth ?></b> экземпляров и <b><?= $pCountPublicationMonth ?></b> новых изданий</p>

            </div>
            <div class="col-md-4">
                <h2>Книжные издания</h2>

                <br>

                <?php $form = ActiveForm::begin(['method' => 'get', 'id' => 'search-book-filter', 'action' => 'book-instances']); ?>

                <?php Pjax::begin(['id' => 'search-book-pjax', 'enablePushState' => false, 'linkSelector' => '.book-field a']) ?>
                <?= $form->field($bModel, isset($bookAttribute) ? $bookAttribute : 'id', [
                    'options' => ['class' => 'book-field'],
                    'template' => '<div class="input-group">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $label . ' <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="' . Url::current(['b-attribute' => 'id']) . '">Инв. номер</a></li>
                            <li><a href="' . Url::current(['b-attribute' => 'publication.name']) . '">Название</a></li>
                            <li><a href="' . Url::current(['b-attribute' => 'publication.isbn']) . '">ISBN</a></li>
                            <li><a href="' . Url::current(['b-attribute' => 'publication.bbk']) . '">ББК</a></li>
                            <li><a href="' . Url::current(['b-attribute' => 'publication.author.initials']) . '">Автор</a></li>
                        </ul>
                    </div>{input}</div>'
                ]) ?>
                <?php Pjax::end() ?>

                <?php ActiveForm::end() ?>

                <br>

                <p>Книжных экземпляров всего <b><?= $bCountInstance ?></b> из <b><?= $bCountPublication ?></b> <a href="book">изданий</a> </p>
                <p>За последний месяц добавлено <b><?= $bCountInstanceMonth ?></b> экземпляров и <b><?= $bCountPublicationMonth ?></b> новых изданий, различным видов</p>
            </div>
        </div>

    </div>
</div>
