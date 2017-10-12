<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.05.2016
 * Time: 10:01
 */

namespace app\utilities;

use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class InstancesColumn extends DataColumn
{
    private $countInstances = 0;

    public function init()
    {
        $this->content = [$this, 'makeInstancesCellContent'];
        \app\assets\InstancesColumnAsset::register($this->grid->view);
        $this->label = $this->label ?: 'Экз.';
    }

    /**
     * @param $model \app\models\publication\PublicationPeriodical
     * @return string
     */
    protected function makeInstancesCellContent($model)
    {
        $popover = $this->makeInstancesPopoverElement($this->getInstanceValues($model));
        $amount = $this->countInstances;
        $this->countInstances = 0;

        return $amount . ' ' . $popover;
    }

    protected function makeInstancesPopoverElement($instances)
    {
        return '<span class="instances-toggler glyphicon glyphicon-list"
            data-toggle="popover"
            role="button"
            data-html="true"
            tabindex="0"
            data-title="Экземпляры издания"
            data-placement="bottom"
            data-content="'. Html::encode($this->makePopoverContent($instances)) .'">
            </span>';
    }

    protected function makePopoverContent($instances)
    {
        if (empty($instances))
            return '';

        $formatter = function ($pair) {
            return sprintf(
                '<td class="popover-table" valign="top"><strong>%s:</strong>&nbsp;%s</td>',
                $pair[0],
                $pair[1]
            );
        };

        $appender = function ($accumulator, $value) {
            return $accumulator . $value;
        };

        $result = '';
        foreach ($instances as $key => $instance) {
            $result .= '<tr>' .array_reduce(array_map($formatter, $instance), $appender, "") . '</tr>';
        }
        return '<div class="popover-instances"><table>' . $result . '</table></div>';

    }

    /**
     * @param $model \app\models\publication\Publication
     * @param $instance \app\models\instance\PublicationInstance
     */
    protected function getInstanceValues($model)
    {
        $result = [];
        $amount = 0;
        $instances = $model->publicationInstances;

        if (!$instances) {
            return $result;
        }

        foreach ($instances as $instance) {
            $result[] = [
                [
                    'Инв.',
                    Html::a($this->formatId($instance['id']), Url::toRoute([$model['type'] == 'periodical' ? '/periodical-instances/view' : '/book-instances/view', 'id' => $instance->id]), ['class' => 'link-dashed'])
                ],
                /*[
                    'Выдана',
                    $instance->given ? 'Да' : 'Нет'
                ],*/
                [
                    'В&nbspархиве',
                    $instance->in_archive ? 'Да' : 'Нет'
                ],
                [
                    'Шкаф',
                    $instance['bookshelf'] ? $instance->bookshelf->bookcase['bookcase'] : null
                ],
                [
                    'Полка',
                    $instance['bookshelf']['bookshelf']
                ],
                [
                    'Утеряна',
                    $instance->lost ? 'Да' : 'Нет'
                ],
            ];

            $amount++;
        }

        $this->countInstances = $amount;

        return $result;
    }

    protected function formatId($id)
    {
        return sprintf('%05d', $id);
    }
}

?>