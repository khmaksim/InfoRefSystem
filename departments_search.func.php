<?php
    header('Content-type: text/html; charset=utf-8');
    // Запуск механизма сессий
    session_start();

    // Механизм авторизации
    include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/auth.php';

    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/date.func.php';

    ConnectDatabase();

    if (isset($_POST['departments_search']) && $_POST['departments_search'] != '') {
?>
                                                <tbody><tr>
                                                  <th>Наименование</th>
                                                  <th class="col-md-1 text-center">Просмотр</th>
                                                </tr>
<?php

        $sql = "SELECT * FROM tdepartments WHERE (UPPER(fullname) LIKE UPPER('%" . $_POST['departments_search'] . "%')) ORDER BY fullname LIMIT 5";
        foreach ($dbconn->query($sql) as $row) {
?>
                                                <tr>
                                                    <td><?= $row['fullname']; ?></td>
                                                    <td class="text-center"><a href="/departments_view.php?id=<?= $row['id']; ?>" class="button btn-warning btn-sm"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                                                </tr>
<?php
        }
?>
                                                </tbody>
<?php
        }
?>
