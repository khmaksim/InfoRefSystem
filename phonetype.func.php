<?php
    header('Content-type: text/html; charset=utf-8');
    // Запуск механизма сессий
    session_start();

    // Механизм авторизации
    include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/auth.php';

    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';

    ConnectDatabase();



                            // Выполним SQL запрос
                            try {
                                $sql = 'SELECT * FROM tphonetype ORDER BY id';
                                foreach ($dbconn->query($sql) as $row) {
                        ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['name']; ?></td>
                            <?php
                                if ($row['editable'] == true) {
                            ?>
                            <td class="col-xs-1 text-center"><a href="/dictionary_edit.php?name=phonetype&act=edit&id=<?= $row['id']; ?>" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-xs-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete('<?= $row['id']; ?>');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                            <?php
                                } else {
                            ?>
                            <td class="col-xs-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-xs-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                            <?php
                                }
                            ?>
                        </tr>
                        <?php
                                }

                            } catch (PDOException $e) {
                                print "Error!: " . $e->getMessage() . "<br />";
                            }
                        ?>