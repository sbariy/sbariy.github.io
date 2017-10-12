<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.06.2016
 * Time: 14:35
 */

use yii\bootstrap\Html;

?>

<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <div style="width: 700px; margin: 0 auto" class="report-instance-report">
        <?= Html::tag('h2', 'ДОБАВЛЕННЫЕ ' .
            ($type == 'periodical' ? 'ПЕРИОДИЧЕСКИЕ ' : 'КНИЖНЫЕ ') . 'ИЗДАНИЯ') ?>

        <?= Html::tag('h3', 'в период от ' . $addedFrom .
        ' до ' . (empty($addedTo) ? date('Y-m-d') : $addedTo)) ?>


        <table cellpadding="5" cellspacing="0">
            <tr bgcolor="#f0f8ff">
                <th style="border-bottom: 1px solid #B3B3B3">Инв.</th>
                <th style="border-bottom: 1px solid #B3B3B3">Название</th>
                <th style="border-bottom: 1px solid #B3B3B3">Вид издания</th>
                <th style="border-bottom: 1px solid #B3B3B3">Дисциплина</th>
                <th style="border-bottom: 1px solid #B3B3B3">Цена</th>
            </tr>
            <?php foreach ($rows as $key => $row): ?>
                <tr bgcolor="#f9f9f9">
                    <td style="border-bottom: 1px solid #B3B3B3"><?= $row['id'] ?></td>
                    <td style="border-bottom: 1px solid #B3B3B3"><?= $row['publication']['name'] ?></td>
                    <td style="border-bottom: 1px solid #B3B3B3"><?= $row['publication']['publicationType']['name'] ?: '--' ?></td>
                    <td style="border-bottom: 1px solid #B3B3B3"><?= $row['discipline']['name'] ?: '--' ?></td>
                    <td style="border-bottom: 1px solid #B3B3B3"><?= $row['price'] ?: '--' ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <h3><span style="margin-right: 50px;">ОБЩЕЕ КОЛИЧЕСТВО: <?= $amount ?></span>&nbsp;&nbsp;&nbsp;<span>ОБЩАЯ СТОИМОСТЬ: <?= $total ?></span></h3>

    </div>
</body>
</html>

