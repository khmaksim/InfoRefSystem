<?php
    header('Content-type: text/html; charset=utf-8');
    // Запуск механизма сессий
    session_start();

    // Механизм авторизации
    include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/auth.php';

    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/date.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getmilitarypositionbyid.func.php';

    ConnectDatabase();

    if (isset($_POST['unit_search']) && $_POST['unit_search'] != '') {
?>
                                                <tbody><tr>
                                                  <th>Наименование</th>
                                                  <th class="col-md-1 text-center">Редактировать</th>
                                                </tr>
<?php

        $sql = "SELECT tu.* FROM tunit tu LEFT JOIN tmilitaryposition tm ON tm.id = tu.id_militaryposition WHERE tu.id_departments = '" . $_POST['id'] . "' AND (UPPER(tm.name) LIKE UPPER('%" . $_POST['unit_search'] . "%')) ORDER BY tm.name LIMIT 5";
        foreach ($dbconn->query($sql) as $row) {
?>
                                                <tr>
                                                    <td><?= getMilitaryPositionById($row['id_militaryposition'])['name']; ?></td>
                                                    <?php
                                                        if ($row['editable'] == true) {
                                                    ?>
                                                    <td class="col-xs-1 text-center"><a href="/unit_edit.php?act=edit&id=<?= $row['id']; ?>&id_departments=<?= $_POST['id']; ?>" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                                    <?php
                                                        } else {
                                                    ?>
                                                    <td class="col-xs-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                                    <?php
                                                        }
                                                    ?>
                                                </tr>
<?php
        }
?>
                                                </tbody>
<?php
        }
?>
