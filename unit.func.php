<?php
    header('Content-type: text/html; charset=utf-8');
    // Запуск механизма сессий
    session_start();

    // Механизм авторизации
    include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/auth.php';

    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/date.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getmilitaryrankbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getmilitarypositionbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getaccesstypebyid.func.php';

    ConnectDatabase();



                            // Выполним SQL запрос
                            try {
                                $sql = "SELECT * FROM tunit WHERE id_departments = '" . $_GET['id'] . "' ORDER BY id";
                                $number = 0;
                                foreach ($dbconn->query($sql) as $row) {
                        ?>
                        <tr>
                            <td><?= ++$number; ?></td>
                            <td><?= getMilitaryPositionById($row['id_militaryposition'])['name']; ?></td>
                            <td><?= getMilitaryRankById($row['id_militaryrank'])['name']; ?></td>
                            <td><?= $row['tariffcategory']; ?></td>
                            <td><?= getAccessTypeById($row['id_accesslevel'])['name']; ?></td>
                            <td><?= $row['ordernumber']; ?></td>
                            <td><?= DateFromENtoRU($row['dateorderstart'], '-'); ?></td>
                            <td><?= $row['orderowner']; ?></td>
                            <td><?= ($row['dateorderend'] != '1970-01-01') ? DateFromENtoRU($row['dateorderend'], '-') : ''; ?></td>
                            <?php
                                if ($row['editable'] == true) {
                            ?>
                            <td class="col-xs-1 text-center"><a href="/unit_edit.php?act=edit&id=<?= $row['id']; ?>&id_departments=<?= $_GET['id']; ?>" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-xs-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
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