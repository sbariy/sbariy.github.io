<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\instance\PublicationInstance */

$this->title = $model['id'];
$this->params['breadcrumbs'][] = ['label' => 'Периодические экземпляры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$formatter = Yii::$app->formatter;

?>

<div class="publication-instance-view">
    <?php \yii\widgets\Pjax::begin(['id' => 'instance-view', 'enablePushState' => false])?>
    <div class="row">
        <div class="col-md-5 body-attribute">
            <table class="body-attribute">
                <tr>
                    <th><span>Название:</span></th>
                    <td><?= $model['publication']['name'] ?></td>
                </tr>
                <tr>
                    <th><span>Вид&nbspиздания:</span></th>
                    <td><?= $model['publication']['publicationType']['name'] ?></td>
                </tr>
                <tr>
                    <th><span>Издатель:</span></th>
                    <td><?= $model['publication']['publisher']['name'] ?></td>
                </tr>
            </table>
        </div>
        <div class="col-md-3 body-attribute">
            <table class="body-attribute">
                <tr>
                    <th><span>Дата&nbspпоступления:</span></th>
                    <td><?= $model['date_add'] ?: '--' ?></td>
                </tr>
                <tr>
                    <th><span>Дата&nbspвыпуска:</span></th>
                    <td><?= $model['publication']['release_date'] ?: '--' ?></td>
                </tr>
            </table>
        </div>
        <div class="col-md-4 body-attribute">
            <table class="body-attribute">
                <tr>
                    <th><span>ISSN:</span></th>
                    <td><?= $model['publication']['issn'] ?: '--' ?></td>
                </tr>
                <tr>
                    <th><span>Инв.&nbspномер:</span></th>
                    <td><?= $model['id'] ?></td>
                </tr>
                <tr>
                    <th><span>Номер&nbspиздания:</span></th>
                    <td><?= !empty($model['publication']['number']) ?: '--' ?></td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-5 body-attribute">
            <table class="body-attribute">
                <tr>
                    <th><span>Цикл:</span></th>
                    <td><?= $model['cycle']['name'] ?: '--' ?></td>
                </tr>
                <tr>
                    <th><span>Дисциплина:</span></th>
                    <td><?= $model['discipline']['name'] ?: '--' ?></td>
                </tr>
            </table>
        </div>
        <div class="col-md-3 body-attribute">
            <table class="body-attribute">
                <tr>
                    <th><span>В архиве:</span></th>
                    <td><?= $formatter->asBoolean($model['in_archive']) ?></td>
                </tr>
                <tr>
                    <th><span>Утеряна:</span></th>
                    <td><?= $formatter->asBoolean($model['lost']) ?></td>
                </tr>
                <tr>
                    <th><span>Шкаф:</span></th>
                    <td><?= $model['bookshelf']['bookcase']['bookcase'] ?: '--' ?></td>
                </tr>
                <tr>
                    <th><span>Полка:</span></th>
                    <td><?= $model['bookshelf']['bookshelf'] ?: '--' ?></td>
                </tr>
            </table>
        </div>
        <div class="col-md-4 body-attribute">
            <table class="body-attribute">
                <tr>
                    <th><span>Цена:</span></th>
                    <td><?= $model['price'] ?: '--' ?></td>
                </tr>
                <tr>
                    <th><span>Рекомендовано:</span></th>
                    <td><?= $formatter->asBoolean($model['publication']['recommended']) ?></td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4 body-attribute body-attribute-block">
            <?= Html::tag('h4', 'Статьи') ?>
            <div class="body-attribute-block"><?= $model['publication']['articlesToString'] ?></div>
        </div>
        <div class="col-md-4 body-attribute body-attribute-block">
            <?= Html::tag('h4', 'Авторы') ?>
            <div class="body-attribute-block"><?= $model['publication']['authorsToString'] ?></div>
        </div>
        <div class="col-md-4 body-attribute">
            <?= Html::tag('h4', 'Аннотация') ?>
            <div class="body-attribute-block"><?= $model['publication']['annotation'] ?></div>
        </div>
    </div>

    <!-- GridView со всеми записями движения книги -->

    <?php \yii\widgets\Pjax::end() ?>

    <div class="buttons-form" style="margin-top: 15px;">
        <?php echo Html::button('В архив', ['class' => 'btn btn-warning btn-in-archive-view', 'instance-id' => $model->id, 'url-ajax' => Url::to(['in-archive'])]);
        echo Html::button('Из архива', ['class' => 'btn btn-warning btn-out-archive-view', 'instance-id' => $model->id, 'url-ajax' => Url::to(['out-archive'])]);
        echo Html::button('Найдена', ['class' => 'btn btn-warning btn-found-view', 'instance-id' => $model->id, 'url-ajax' => Url::to(['found'])]);
        echo Html::button('Потеряна', ['class' => 'btn btn-warning btn-lost-view', 'instance-id' => $model->id, 'url-ajax' => Url::to(['lost'])]);
        echo Html::button(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil']), ['class' => 'btn btn-primary btn-dialog-update-instance', 'url-pjax' => Url::toRoute(['update', 'id' => $model->id])]);
        echo Html::button('Удалить', ['class' => 'btn btn-danger btn-delete-view', 'instance-id' => $model->id, 'url-ajax' => Url::toRoute(['delete', 'id' => $model->id])]); ?>
    </div>
</div>

