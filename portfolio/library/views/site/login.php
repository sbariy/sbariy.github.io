<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use app\assets\AppAsset;
use app\components\AlertWidget;
use yii\bootstrap\ActiveForm;

$this->title = 'Форма входа';
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container">
        <?= AlertWidget::widget() ?>

        <!-- Форма авторизации -->
        <div class="site-login">
            <div class="panel panel-primary">
                <div class="panel-heading"><span class="title"><?= Html::encode($this->title) ?></span></div>
                <div class="panel-body">

                        <?php $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'fieldConfig' => [
                                'labelOptions' => ['class' => 'col-lg-1 control-label'],
                            ],
                        ]); ?>

                        <?= $form->field($model, 'username', ['template' => '{input}{error}'])->textInput(['autofocus' => true, 'placeholder' => 'логин']) ?>

                        <?= $form->field($model, 'password', ['template' => '{input}{error}'])->passwordInput(['placeholder' => 'пароль']) ?>

                        <?= $form->field($model, 'rememberMe')->checkbox(['label' => 'Запомнить меня']) ?>

                        <p class="line-multiple-block"></p>

                        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button width-max']) ?>

                        <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
