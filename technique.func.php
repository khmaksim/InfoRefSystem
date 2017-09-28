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
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getaccesstypebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getunitbyid.func.php';

    ConnectDatabase();

                            // Выполним SQL запрос
                            try {
                                $sql = "SELECT * FROM ttechnique WHERE id_departments = '" . $_GET['id'] . "' ORDER BY id";
                                $number = 0;
                                foreach ($dbconn->query($sql) as $row) {
                        ?>
                        <tr>
                            <td><?= ++$number; ?></td>
                            <td><?= $row['fullname']; ?></td>
                            <td><?= $row['shortname']; ?></td>
                            <td class="col-xs-1 text-center"><a href="/technique_view.php?id=<?= $row['id']; ?>&id_departments=<?= $_GET['id']; ?>" target="_blank" class="button btn-warning btn-sm"><span class="glyphicon glyphicon-print"></span></a></td>
                            <td class="col-xs-1 text-center"><a href="/technique_edit.php?act=edit&id=<?= $row['id']; ?>&id_departments=<?= $_GET['id']; ?>" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-md-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete('<?= $row['id']; ?>');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                        </tr>
                        <?php
                                }
                            } catch (PDOException $e) {
                                print "Error!: " . $e->getMessage() . "<br />";
                            }
                        ?>