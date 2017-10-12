<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.05.2016
 * Time: 6:32
 */

?>
<div class="grid-view">
    <table class="table table-bordered">
        <tr>
            <th>Инв. номер</th>
            <th>Цена</th>
            <th>Шкаф</th>
            <th>Полка</th>
            <th>Дисциплина</th>
            <th>Учебный цикл</th>
        </tr>

        <?php foreach ($rows as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['price'] ?></td>
            <td><?= $row['bookshelf']['bookcase']['bookcase'] ?></td>
            <td><?= $row['bookshelf']['bookshelf'] ?></td>
            <td><?= $row['discipline']['name'] ?></td>
            <td><?= $row['cycle']['name'] ?></td>
        </tr>
        <?php endforeach; ?>

    </table>
</div>