<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\AlertWidget;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode('Библиотечный фонд СПБГЭУ') ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Библиотечный фонд СПБГЭУ',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Главная', 'url' => ['/']],
            [
                'label' => 'Периодика',
                'items' => [
                    ['label' => 'Экземпляры', 'url' => ['/periodical-instances']],
                    ['label' => 'Издания', 'url' => ['/periodical']],
                    '<li role="separator" class="divider"></li>',
                    ['label' => 'Авторы', 'url' => ['/author']],
                    ['label' => 'Издатели', 'url' => ['/publisher']],
                    ['label' => 'Виды изданий', 'url' => ['/publication-type']],
                    '<li role="separator" class="divider"></li>',
                    ['label' => 'Учебные циклы', 'url' => ['/cycle']],
                    ['label' => 'Дисциплины', 'url' => ['/discipline']],
                    '<li role="separator" class="divider"></li>',
                    ['label' => 'Шкафы', 'url' => ['/bookcase']]
                ]
            ],
            [
                'label' => 'Книги',
                'items' => [
                    ['label' => 'Экземпляры', 'url' => ['/book-instances']],
                    ['label' => 'Издания', 'url' => ['/book']],
                    '<li role="separator" class="divider"></li>',
                    ['label' => 'Авторы', 'url' => ['/author']],
                    ['label' => 'Издатели', 'url' => ['/publisher']],
                    ['label' => 'Виды изданий', 'url' => ['/publication-type']],
                    '<li role="separator" class="divider"></li>',
                    ['label' => 'Учебные циклы', 'url' => ['/cycle']],
                    ['label' => 'Дисциплины', 'url' => ['/discipline']],
                    '<li role="separator" class="divider"></li>',
                    ['label' => 'Шкафы', 'url' => ['/bookcase']]
                ]
            ],
            ['label' => 'Библиотекари', 'url' => ['/user']],
            ['label' => 'Отчёты', 'url' => ['/report']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    Html::tag('span', '', ['class' => 'glyphicon glyphicon-off'])
                    .' Выйти<br>(' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= AlertWidget::widget() ?>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Электронный каталог СПБГЭУ <?= date('Y') ?></p>

        <p class="pull-right"><?= 'Создано в СПБПЭК' ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
